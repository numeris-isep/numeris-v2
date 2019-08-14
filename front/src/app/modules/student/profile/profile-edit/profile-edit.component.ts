import { Component, OnInit } from '@angular/core';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { User } from '../../../../core/classes/models/user';
import { AuthService } from '../../../../core/http/auth/auth.service';
import { ActivatedRoute, Router } from '@angular/router';
import { TitleService } from '../../../../core/services/title.service';
import { FormBuilder, FormGroup } from '@angular/forms';
import { UserService } from '../../../../core/http/user.service';
import { first } from 'rxjs/operators';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';
import { AlertService } from '../../../../core/services/alert.service';
import { dateToString } from '../../../../shared/utils';

@Component({
  selector: 'app-profile-edit',
  templateUrl: './profile-edit.component.html'
})
export class ProfileEditComponent implements OnInit {

  user: User;
  data: User;
  userForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private authService: AuthService,
    private userService: UserService,
    private alertService: AlertService,
    private titleService: TitleService,
    private formBuilder: FormBuilder,
    private breadcrumbsService: BreadcrumbsService,
  ) { }

  ngOnInit() {
    this.getCurrentUser();
    this.initForm();
  }

  getCurrentUser() {
    this.authService.getCurrentUser().subscribe(user => {
      this.user = user;

      this.titleService.setTitles(`Profil - Modifier`);
      this.breadcrumbsService.setBreadcrumb(
        this.route.snapshot,
        [{ title: 'Profil', url: '/profil' }, { title: 'Modifier', url: '' }]
      );
    });
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

    console.log(this.data);

    this.userService.updateUser(this.data, this.user)
      .pipe(first())
      .subscribe(
        user => {
          this.loading = false;
          this.router.navigate(['/profil']);
          this.alertService.success([`Votre profil a bien été modifié.`]);
        },
        errors => {
          handleFormErrors(this.userForm, errors);
          this.loading = false;
        },
      );
  }

}
