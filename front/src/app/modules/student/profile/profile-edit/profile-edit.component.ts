import { Component, OnInit, ViewChild } from '@angular/core';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { User } from '../../../../core/classes/models/user';
import { AuthService } from '../../../../core/http/auth/auth.service';
import { ActivatedRoute, Router } from '@angular/router';
import { TitleService } from '../../../../core/services/title.service';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { UserEditFormComponent } from '../../../../shared/components/forms/user-edit-form/user-edit-form.component';
import { handleFormDeactivation } from '../../../../core/functions/form-deactivate-handler';

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
    return handleFormDeactivation(this.userEditFormComponent, 'userForm');
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
