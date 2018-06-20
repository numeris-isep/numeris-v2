import { Component, OnInit } from '@angular/core';
import { SessionService } from "../../services/session.service";
import { Router } from "@angular/router";
import { TokenService } from "../../services/token.service";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {

  public loggedIn: boolean;

  constructor(
    private tokenService: TokenService,
    private authService: SessionService,
    private router: Router
  ) { }

  ngOnInit() {
    this.authService.authStatus.subscribe(value => this.loggedIn = value);
  }

  logout(event: MouseEvent) {
    event.preventDefault();
    this.tokenService.remove();
    this.authService.changeAuthStatus(false);
    this.router.navigateByUrl('/login');
  }

}
