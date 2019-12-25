import { Component, Input, OnInit } from '@angular/core';
import { User } from '../../../../core/classes/models/user';
import { UserService } from '../../../../core/http/user.service';
import { AlertService } from '../../../../core/services/alert.service';
import { Router } from '@angular/router';
import { AuthService } from '../../../../core/http/auth/auth.service';
import { environment } from '../../../../../environments/environment';

@Component({
  selector: 'app-activate-account-message',
  templateUrl: './activate-account-message.component.html'
})
export class ActivateAccountMessageComponent implements OnInit {

  @Input() user: User;
  isCompleted: boolean;
  loading: boolean = false;

  savEmail: string = environment.savEmail;

  constructor(
    private authService: AuthService,
    private userService: UserService,
    private alertService: AlertService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.isCompleted = ! (
      !this.user.phone
      || !this.user.birthCity
      || !this.user.nationality
      || !this.user.socialInsuranceNumber
      || !this.user.bic
    );
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
