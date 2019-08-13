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
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    public subscribeModal: SuiModal<void, void, void>,
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.initForm();
  }

  get f() { return this.subscribeForm.controls; }

  initForm() {
    this.subscribeForm = this.formBuilder.group({});
  }

  addUserForm(userForm: FormGroup) {
    this.subscribeForm.addControl('first_name', userForm.controls.first_name);
    this.subscribeForm.addControl('last_name', userForm.controls.last_name);
    this.subscribeForm.addControl('email', userForm.controls.email);
    this.subscribeForm.addControl('promotion', userForm.controls.promotion);
    this.subscribeForm.addControl('birth_date', userForm.controls.birth_date);
  }

  addPasswordForm(passwordForm: FormGroup) {
    this.subscribeForm.addControl('password', passwordForm.controls.password);
    this.subscribeForm.addControl('password_confirmation', passwordForm.controls.password_confirmation);
  }

  addAddressForm(addressForm: FormGroup) {
    this.subscribeForm.addControl('address', addressForm);
  }

  onSubmit() {
    this.submitted = true;

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
