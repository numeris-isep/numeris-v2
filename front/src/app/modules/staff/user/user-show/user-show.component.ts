import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { UserService } from '../../../../core/http/user.service';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { User } from '../../../../core/classes/models/user';
import { AuthService } from '../../../../core/http/auth/auth.service';
import { AlertService } from '../../../../core/services/alert.service';

@Component({
  selector: 'app-user-show',
  templateUrl: './user-show.component.html',
  styleUrls: ['./user-show.component.css']
})
export class UserShowComponent implements OnInit {

  user: User;
  currentUserId: number;
  loading: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private userService: UserService,
    private authService: AuthService,
    private titleService: TitleService,
    private breadcrumbService: BreadcrumbsService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getUser(parseInt(param.userId));
    });

    this.getCurrentUser();
  }

  getUser(userId: number) {
    return this.userService.getUser(userId).subscribe(user => {
        this.user = user;
        let name = 'Utilisateur sans nom';

        if (user.firstName && user.lastName) {
          name = `${user.firstName} ${user.lastName.toUpperCase()}`;
        }

        this.titleService.setTitles(name);
        this.breadcrumbService.setBreadcrumb(
          this.route.snapshot,
          { title: name, url: '' }
        );
    });
  }

  getCurrentUser() {
    this.currentUserId = this.authService.getCurrentUserId();
  }

  updateActivated() {
    this.loading = true;

    this.userService.updateUserActivated(!this.user.activated, this.user).subscribe(
      user => {
        this.user.activated = user.activated;
        this.alertService.success([
          `L'utilisateur ${user.firstName} ${user.lastName.toUpperCase()} a bien été ${ user.activated ? 'activé' : 'désactivé' }`
        ]);
        this.loading = false;
      }
    );
  }

}
