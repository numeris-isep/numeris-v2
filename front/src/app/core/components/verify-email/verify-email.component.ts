import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../http/auth/auth.service';
import { AlertService } from '../../services/alert.service';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-verify-email',
  templateUrl: './verify-email.component.html',
})
export class VerifyEmailComponent implements OnInit {

  data: {
    expires: string;
    id: string;
    signature: string;
  };

  constructor(
    private authService: AuthService,
    private alertService: AlertService,
    private route: ActivatedRoute,
    private router: Router,
  ) { }

  ngOnInit() {
    this.route.queryParams.subscribe(param => {
      this.data = {
        expires: param.expires,
        id: param.id,
        signature: param.signature
      };

      this.validateEmail();
    });
  }

  validateEmail() {
    this.authService.validateEmail(this.data).subscribe(
      message => {
        this.router.navigate(['profil']);
        this.alertService.success(message.message);
      }
    );
  }

}
