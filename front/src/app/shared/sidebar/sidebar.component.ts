import { Component, OnInit } from '@angular/core';
import { Observable } from "rxjs";
import { AuthService } from "../../auth/auth.service";
import { ScrollToElementService } from "../_services/scroll-to-element.service";

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.scss']
})
export class SidebarComponent implements OnInit {

  isLoggedIn$: Observable<boolean>;

  constructor(
    private authService : AuthService,
    private scrollService: ScrollToElementService
  ) { }

  ngOnInit() {
    this.isLoggedIn$ = this.authService.isLoggedIn;
  }

  scrollToElement(anchor: string) {
    this.scrollService.scrollToElement(anchor);
  }

  // This is to avoid red underlining from the IDE
  open(): void {}
  close(): void {}
  toggle(): void {}
}
