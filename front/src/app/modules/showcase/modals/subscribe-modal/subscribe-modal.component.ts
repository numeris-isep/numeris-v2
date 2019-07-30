import { Component, OnInit } from '@angular/core';
import { ComponentModalConfig, ModalSize, SuiModal } from 'ng2-semantic-ui';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from '../../../../core/http/auth/auth.service';
import { first } from 'rxjs/operators';
import { AlertService } from '../../../../core/services/alert.service';
import { User } from '../../../../core/classes/models/user';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';
import { dateToString, dateToYear } from '../../../../shared/utils';
import * as moment from 'moment';

@Component({
  selector: 'app-subscribe-modal',
  templateUrl: './subscribe-modal.component.html',
  styleUrls: ['./subscribe-modal.component.html'],
})
export class SubscribeModalComponent implements OnInit {

  subscribeForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;
  minPromotion = moment().subtract(1, 'year').toDate();

  constructor(
    public subscribeModal: SuiModal<void, void, void>,
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.subscribeForm = this.formBuilder.group({
      email: ['', Validators.required],
      password: ['', Validators.required],
      password_confirmation: ['', Validators.required],
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      promotion: ['', Validators.required],
      birth_date: ['', Validators.required],
      address: this.formBuilder.group({
        street: ['', Validators.required],
        zip_code: ['', Validators.required],
        city: ['', Validators.required],
      })
    });
  }

  get f() { return this.subscribeForm.controls; }

  fa(field: string) { return this.subscribeForm.get(`address.${field}`); }

  onSubmit() {
    this.submitted = true;

    if (this.subscribeForm.invalid) { return; }

    this.loading = true;
    this.f.birth_date.setValue(dateToString(this.f.birth_date.value));
    this.f.promotion.setValue(dateToYear(this.f.promotion.value));

    this.authService.subscribe(this.subscribeForm.value)
      .pipe(first())
      .subscribe(
        (user: User) => {
          this.subscribeModal.approve(undefined);
          this.authService.login(user.email, this.f.password.value).subscribe(
            _ => this.alertService.success([`Bienvenue chez Numéris, ${user.firstName} !`], 'Inscription réussie')
          );
        },
        errors => {
          handleFormErrors(this.subscribeForm, errors);
          this.loading = false;
        }
      );
  }

}

export class SubscribeModal extends ComponentModalConfig<void, void, void> {

  constructor(
    size = ModalSize.Normal,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(SubscribeModalComponent);

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }
}
