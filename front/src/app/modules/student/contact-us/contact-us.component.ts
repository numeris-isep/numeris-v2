import { Component, OnInit } from '@angular/core';
import { SuiModalService } from 'ng2-semantic-ui';
import { ContactUsModal } from '../../showcase/modals/contact-us-modal/contact-us-modal.component';
import { environment } from '../../../../environments/environment';
import { AuthService } from '../../../core/http/auth/auth.service';
import { User } from '../../../core/classes/models/user';

@Component({
  selector: 'app-contact-us',
  templateUrl: './contact-us.component.html',
  styleUrls: ['./contact-us.component.css']
})
export class ContactUsComponent implements OnInit {

  user: User;
  contactUsModal: ContactUsModal;
  messengerUrl: string = environment.messengerUrl;

  constructor(
    private authService: AuthService,
    private modalService: SuiModalService,
  ) { }

  ngOnInit() {
    this.getCurrentUser();
  }

  getCurrentUser() {
    this.authService.getCurrentUser().subscribe(user => {
      this.user = user;
      this.contactUsModal = new ContactUsModal(user);
    });
  }

  openModal() {
    this.modalService.open(this.contactUsModal);
  }

}
