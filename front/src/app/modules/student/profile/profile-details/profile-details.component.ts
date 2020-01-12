import { Component, Input, OnInit } from '@angular/core';
import { User } from '../../../../core/classes/models/user';
import { ProfileDeleteModal } from '../profile-delete-modal/profile-delete-modal.component';
import { SuiModalService } from 'ng2-semantic-ui';

@Component({
  selector: 'app-profile-details',
  templateUrl: './profile-details.component.html'
})
export class ProfileDetailsComponent implements OnInit {

  @Input() user: User;
  @Input() currentUserId: number;

  modal: ProfileDeleteModal;

  constructor(private modalService: SuiModalService) { }

  ngOnInit() {
    this.modal = new ProfileDeleteModal(this.user);
  }

  openModal() {
    if (this.user.deletedAt) { return; }

    this.modalService.open(this.modal);
  }

}
