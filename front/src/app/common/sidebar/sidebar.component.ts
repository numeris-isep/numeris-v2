import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../auth/auth.service";
import { Observable } from "rxjs";

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html'
})
export class SidebarComponent implements OnInit {

  isLoggedIn$: Observable<boolean>;

  constructor(private authService : AuthService) { }

  ngOnInit() {
    this.isLoggedIn$ = this.authService.isLoggedIn;
  }
}
