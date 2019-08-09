import { Component, OnInit } from '@angular/core';
import { ComponentModalConfig, ModalSize, SuiModal } from 'ng2-semantic-ui';
import { AbstractControl, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from '../../../../core/http/auth/auth.service';
import { first } from 'rxjs/operators';
import { AlertService } from '../../../../core/services/alert.service';
import { User } from '../../../../core/classes/models/user';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';
import { dateToString } from '../../../../shared/utils';
import * as moment from 'moment';

@Component({
  selector: 'app-subscribe-modal',
  templateUrl: './subscribe-modal.component.html',
  styleUrls: ['../contact-us-modal/contact-us-modal.component.css']
})
export class SubscribeModalComponent implements OnInit {

  subscribeForm: FormGroup;
  addressForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;
  promotions: number[] = [];

  constructor(
    public subscribeModal: SuiModal<void, void, void>,
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.initPromotions();
    this.initForm();
  }

  get f() { return this.subscribeForm.controls; }

  fa(field: string) { return this.subscribeForm.get(`address.${field}`); }

  initPromotions() {
    let currentYear = moment().get('year');

    for (let i = 0; i < 7; i++) {
      this.promotions.push(currentYear);
      currentYear++;
    }
  }

  initForm() {
    this.subscribeForm = this.formBuilder.group({
      email: ['', Validators.required],
      password: ['', Validators.required],
      password_confirmation: ['', Validators.required],
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      promotion: ['', Validators.required],
      birth_date: ['', Validators.required],
    });
  }

  addAddressForm(addressForm: FormGroup) {
    this.subscribeForm.addControl('address', addressForm);
  }

  onSubmit() {
    this.submitted = true;

    console.log(this.subscribeForm.value);

    if (this.subscribeForm.invalid) { return; }

    this.loading = true;
    this.f.birth_date.setValue(dateToString(this.f.birth_date.value));

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

  suffix() {
    const email: AbstractControl = this.f.email;

    if (! email.value.includes('@isep.fr')) {
      email.setValue(email.value + 'isep.fr');
    }
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
