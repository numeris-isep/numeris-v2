import { Component, Input, OnInit } from '@angular/core';
import { User } from '../../../../core/classes/models/user';
import { FormBuilder, FormGroup } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { UserService } from '../../../../core/http/user.service';
import { AlertService } from '../../../../core/services/alert.service';
import { dateToString } from '../../../utils';
import { first } from 'rxjs/operators';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';

@Component({
  selector: 'app-user-edit-form',
  templateUrl: './user-edit-form.component.html'
})
export class UserEditFormComponent implements OnInit {

  @Input() user: User;
  @Input() ownProfile: boolean = true;
  returnUrl: string = '/profil';
  data: User;
  userForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private userService: UserService,
    private alertService: AlertService,
    private formBuilder: FormBuilder,
  ) { }

  ngOnInit() {
    this.initForm();
    this.returnUrl = this.ownProfile ? this.returnUrl : `/utilisateurs/${this.user.id}`;
  }

  initForm() {
    this.userForm = this.formBuilder.group({});
  }

  addProfileForm(profileForm: FormGroup) {
    this.userForm = profileForm;
  }

  get f() { return this.userForm.controls; }

  onSubmit() {
    this.submitted = true;

    if (this.userForm.invalid) { return; }

    this.loading = true;

    this.data = this.userForm.value;
    this.data.birth_date = this.data.birth_date ? dateToString(this.data.birth_date) : '';
    this.data.phone = this.data.phone ? this.data.phone.replace(/\s/g, '') : '';
    this.data.iban = this.data.iban ? this.data.iban.replace(/\s/g, '') : '';
    this.data.social_insurance_number = this.data.social_insurance_number ? this.data.social_insurance_number.replace(/\s/g, '') : '';

    this.userService.updateUser(this.data, this.user)
      .pipe(first())
      .subscribe(
        user => {
          this.loading = false;
          this.router.navigate([this.returnUrl]);
          this.alertService.success([this.ownProfile ? 'Votre profil a bien été modifié.' : `L'utilisateur a bien été modifié.`]);
        },
        errors => {
          handleFormErrors(this.userForm, errors);
          this.loading = false;
        },
      );
  }

}
