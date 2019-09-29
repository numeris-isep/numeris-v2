import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from '../../../../core/http/auth/auth.service';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';
import { AlertService } from '../../../../core/services/alert.service';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-reset-password-form',
  templateUrl: './reset-password-form.component.html'
})
export class ResetPasswordFormComponent implements OnInit {

  email: string;
  token: string;
  resetting: boolean = false;
  resetPasswordForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.getParameters();
  }

  getParameters() {
    this.route.queryParams.subscribe(param => {
      this.email = param.email;
      this.token = param.token;

      this.resetting = !! (this.email && this.token);

      this.initForm();
    });
  }

  initForm() {
    this.resetPasswordForm = this.formBuilder.group({
      email: [this.email || '', Validators.required],
    });
  }

  addPasswordForm(passwordForm: FormGroup) {
    this.resetPasswordForm.addControl('password', passwordForm.controls.password);
    this.resetPasswordForm.addControl('password_confirmation', passwordForm.controls.password_confirmation);
  }

  get f() { return this.resetPasswordForm.controls; }

  onSubmit() {
    this.submitted = true;

    if (this.resetPasswordForm.invalid) { return; }

    this.loading = true;

    this.email && this.token ? this.resetPassword() : this.forgotPassword();
  }

  forgotPassword() {
    this.authService.forgotPassword(this.f.email.value)
      .subscribe(
        message => {
          this.loading = false;
          this.alertService.success(message.message);
        },
        errors => {
          handleFormErrors(this.resetPasswordForm, errors);
          this.loading = false;
        },
      );
  }

  resetPassword() {
    this.authService.resetPassword(Object.assign(this.resetPasswordForm.value, { token: this.token }))
      .subscribe(
        message => {
          this.loading = false;
          this.alertService.success(message.message);
        },
        errors => {
          handleFormErrors(this.resetPasswordForm, errors);
          this.loading = false;
        },
      );
  }

}
