import { Component, Input, OnInit } from '@angular/core';
import { SidebarComponent } from "../sidebar/sidebar.component";
import { Observable } from "rxjs";
import { SuiModalService } from "ng2-semantic-ui";
import { LoginModal } from "../modals/login-modal/login-modal.component";

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html'
})
export class MenuComponent implements OnInit {

  @Input() isLoggedIn$: Observable<boolean>;
  @Input() sidebar : SidebarComponent;

  private modal: LoginModal = new LoginModal();

  constructor(private modalService: SuiModalService) {}

  ngOnInit() {
  }

  openModal() {
    this.modalService.open(this.modal)
  }

}
