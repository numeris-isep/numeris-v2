import { Component, Input, OnInit } from '@angular/core';
import { SidebarComponent } from '../sidebar/sidebar.component';
import { Observable } from 'rxjs';
import { ComponentModalConfig, SuiModalService } from 'ng2-semantic-ui';
import { LoginModal } from '../../../modules/showcase/modals/login-modal/login-modal.component';
import { AuthService } from '../../http/auth/auth.service';
import { Router } from '@angular/router';
import { ScrollService } from '../../services/scroll.service';
import { SubscribeModal } from '../../../modules/showcase/modals/subscribe-modal/subscribe-modal.component';

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html',
  styleUrls: ['./menu.component.css']
})
export class MenuComponent implements OnInit {

  isLoggedIn$: Observable<boolean>;

  @Input() sidebar: SidebarComponent;

  private loginModal: LoginModal = new LoginModal();
  private subscribeModal: SubscribeModal = new SubscribeModal();

  constructor(
    private modalService: SuiModalService,
    private authService: AuthService,
    private router: Router,
    private scrollService: ScrollService
  ) {}

  ngOnInit() {
    this.isLoggedIn$ = this.authService.isLoggedIn;
  }

  openModal(modal: ComponentModalConfig<any, void, void>) {
    this.modalService.open(modal);
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
