import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../services/auth.service";
import { TokenService } from "../../services/token.service";

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

  constructor(
    private auth: AuthService,
    private token: TokenService
  ) { }

  ngOnInit() {
  }

  onSubmit() {
    this.auth.login(this.form).subscribe(
      data => this.handleResponse(data),
      error => console.log(error)
    );
  }

  handleResponse(data) {
    this.token.handle(data.access_token);
  }
}
