import { Component, OnInit, ViewChild } from '@angular/core';
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
import { dateToString, equals } from '../../../../shared/utils';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { UserEditFormComponent } from '../../../../shared/components/forms/user-edit-form/user-edit-form.component';

@Component({
  selector: 'app-profile-edit',
  templateUrl: './profile-edit.component.html'
})
export class ProfileEditComponent implements OnInit, CanComponentDeactivate {

  @ViewChild(UserEditFormComponent) userEditFormComponent: UserEditFormComponent;

  user: User;

  constructor(
    private route: ActivatedRoute,
    private authService: AuthService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService,
  ) { }

  ngOnInit() {
    this.getCurrentUser();
  }

  canDeactivate() {
    try {
      return equals(
        this.userEditFormComponent.initialValue,
        this.userEditFormComponent.userForm.value
      );
    } catch (e) {
      return true;
    }
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
}
