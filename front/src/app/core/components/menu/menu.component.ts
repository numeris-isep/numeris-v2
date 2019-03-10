import { Component, Input, OnInit } from '@angular/core';
import { SidebarComponent } from "../sidebar/sidebar.component";
import { Observable } from "rxjs";
import { SuiModalService } from "ng2-semantic-ui";
import { LoginModal } from "../../../shared/components/modals/login-modal/login-modal.component";
import { AuthService } from "../../auth/auth.service";
import { Router } from "@angular/router";
import { ScrollService } from "../../services/scroll.service";
import { AlertService } from "../../services/alert.service";

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html',
  styleUrls: ['./menu.component.css']
})
export class MenuComponent implements OnInit {

  isLoggedIn$: Observable<boolean>;

  @Input() sidebar: SidebarComponent;

  private modal: LoginModal = new LoginModal();

  constructor(
    private modalService: SuiModalService,
    private authService: AuthService,
    private router: Router,
    private scrollService: ScrollService
  ) {}

  ngOnInit() {
    this.isLoggedIn$ = this.authService.isLoggedIn;
  }

  openModal() {
    this.modalService.open(this.modal);
  }

  logout() {
    this.sidebar.close();
    this.authService.logout();
    this.router.navigate(['/']);
  }

  scrollToElement(anchor: string) {
    this.scrollService.scrollToElement(anchor);
  }
}