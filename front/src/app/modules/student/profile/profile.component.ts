import { Component, OnInit } from '@angular/core';
import { User } from '../../../core/classes/models/user';
import { AuthService } from '../../../core/http/auth/auth.service';
import { UserService } from '../../../core/http/user.service';
import { AlertService } from '../../../core/services/alert.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {

  user: User;
  loading: boolean = false;

  constructor(
    private authService: AuthService,
    private userService: UserService,
    private alertService: AlertService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.getCurrentUser();
  }

  getCurrentUser() {
    this.authService.getCurrentUser().subscribe(user => this.user = user);
  }

  activateUser() {
    this.loading = true;

    this.userService.updateUserActivated(true, this.user).subscribe(
      user => {
        this.alertService.success(['Votre profil a bien été activé']);
        this.authService.logout();
        this.router.navigate([''], { queryParams: { returnUrl: 'profil'} });
        this.loading = false;
      }
    );
  }

}
