import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../../services/auth.service";

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
})
export class SidebarComponent implements OnInit {

  isLoggedIn: boolean;

  constructor(private authService : AuthService) { }

  ngOnInit() {
    this.authService.isLoggedIn
      .subscribe((value) => this.isLoggedIn = value);
  }

}
