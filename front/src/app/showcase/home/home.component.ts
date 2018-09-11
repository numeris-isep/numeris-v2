import { Component, OnInit } from '@angular/core';
import { TokenService } from "../../auth/token.service";
import { AuthService } from "../../auth/auth.service";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  constructor(
    private tokenService: TokenService,
    private authService: AuthService
  ) { }

  ngOnInit() {
    // reset login status
    this.authService.resetAuthStatus();
  }

}
