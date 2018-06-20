import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../services/auth.service";
import { TokenService } from "../../services/token.service";
import { ActivatedRoute, Router } from "@angular/router";
import { SessionService } from "../../services/session.service";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  public form = {
    email: null,
    password: null
  };

  returnUrl: string;

  constructor(
    private loginService: AuthService,
    private tokenService: TokenService,
    private authService: SessionService,
    private router: Router,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/profile';

  }

  login() {
    this.loginService.login(this.form).subscribe(
      data => this.handleResponse(data),
      error => console.log(error) // TODO: error handling
    );
  }

  handleResponse(data) {
    this.tokenService.handle(data.access_token);
    this.authService.changeAuthStatus(true);
    this.router.navigateByUrl(this.returnUrl);
  }
}
