import { Component, OnInit } from '@angular/core';
import { User } from '../../../../core/classes/models/user';
import { FormBuilder, FormGroup } from '@angular/forms';
import { UserService } from '../../../../core/http/user.service';
import { AlertService } from '../../../../core/services/alert.service';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { ActivatedRoute } from '@angular/router';
import { dateToString } from '../../../../shared/utils';
import { first } from 'rxjs/operators';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';

@Component({
  selector: 'app-user-edit',
  templateUrl: './user-edit.component.html'
})
export class UserEditComponent implements OnInit {

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
