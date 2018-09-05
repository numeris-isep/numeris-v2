import { Component, Input, OnInit } from '@angular/core';
import { SidebarComponent } from "../sidebar.component";
import { AuthService } from "../../../../services/auth.service";

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html'
})
export class MenuComponent implements OnInit {

  isLoggedIn: boolean;

  @Input() sidebar : SidebarComponent;

  constructor(private authService : AuthService) {}

  ngOnInit() {
    this.authService.isLoggedIn
      .subscribe((value) => this.isLoggedIn = value);
  }

}
