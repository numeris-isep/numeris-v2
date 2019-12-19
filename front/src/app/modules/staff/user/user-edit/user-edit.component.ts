import { Component, OnInit, ViewChild } from '@angular/core';
import { User } from '../../../../core/classes/models/user';
import { UserService } from '../../../../core/http/user.service';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { ActivatedRoute } from '@angular/router';
import { UserEditFormComponent } from '../../../../shared/components/forms/user-edit-form/user-edit-form.component';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { handleFormDeactivation } from '../../../../core/functions/form-deactivate-handler';

@Component({
  selector: 'app-user-edit',
  templateUrl: './user-edit.component.html'
})
export class UserEditComponent implements OnInit, CanComponentDeactivate {

  @ViewChild(UserEditFormComponent) userEditFormComponent: UserEditFormComponent;

  user: User;

  constructor(
    private route: ActivatedRoute,
    private userService: UserService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService,
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getUser(parseInt(param.userId));
    });
  }

  canDeactivate() {
    return handleFormDeactivation(this.userEditFormComponent, 'userForm');
  }

  getUser(userId: number) {
    this.userService.getUser(userId).subscribe(user => {
      this.user = user;

      this.titleService.setTitles(`${user.firstName} ${user.lastName.toUpperCase()} - Modifier`);
      this.breadcrumbsService.setBreadcrumb(
        this.route.snapshot,
        [
          { title: `${user.firstName} ${user.lastName.toUpperCase()}`, url: `/utilisateurs/${user.id}` },
          { title: 'Modifier', url: '' }
          ]
      );
    });
  }
}
