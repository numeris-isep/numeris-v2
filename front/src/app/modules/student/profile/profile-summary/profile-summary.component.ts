import { Component, Input, OnInit } from '@angular/core';
import { User } from '../../../../core/classes/models/user';
import { AuthService } from '../../../../core/http/auth/auth.service';
import { SuiModalService } from 'ng2-semantic-ui';
import { ProfileRoleModal } from '../profile-role-modal/profile-role-modal.component';

@Component({
  selector: 'app-profile-summary',
  templateUrl: './profile-summary.component.html',
  styleUrls: ['./profile-summary.component.css']
})
export class ProfileSummaryComponent implements OnInit {

  @Input() user: User;
  currentUserRole: string;

  constructor(
    private authService: AuthService,
    private modalService: SuiModalService,
  ) { }

  ngOnInit() {
    this.currentUserRole = this.authService.getCurrentUserRole();
  }

  openModal() {
    this.modalService.open(
      new ProfileRoleModal(this.user)
    );
  }

}
