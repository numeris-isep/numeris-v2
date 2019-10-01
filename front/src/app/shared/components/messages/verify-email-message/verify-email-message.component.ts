import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../../../core/http/auth/auth.service';
import { AlertService } from '../../../../core/services/alert.service';

@Component({
  selector: 'app-verify-email-message',
  templateUrl: './verify-email-message.component.html'
})
export class VerifyEmailMessageComponent implements OnInit {

  loading: boolean = false;

  constructor(
    private authService: AuthService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
  }

  sendEmail() {
    this.loading = true;

    this.authService.verifyEmail().subscribe(
      message => {
        this.alertService.success(message.message);

        this.loading = false;
      }
    );
  }

}
