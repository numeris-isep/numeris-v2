import { Component, OnInit } from '@angular/core';
import { User } from '../../../../core/classes/models/user';
import { ComponentModalConfig, ModalSize, SuiModal } from 'ng2-semantic-ui';
import { UserService } from '../../../../core/http/user.service';
import { AlertService } from '../../../../core/services/alert.service';
import { DialogService } from '../../../../core/services/dialog.service';
import { AuthService } from '../../../../core/http/auth/auth.service';
import { Router } from '@angular/router';
import * as moment from 'moment';

export interface IProfileDeletedModalContext {
  user: User;
}

@Component({
  selector: 'app-profile-delete-modal',
  templateUrl: './profile-delete-modal.component.html'
})
export class ProfileDeleteModalComponent implements OnInit {

  user: User = this.modal.context.user;
  isOwnProfile: boolean;
  loading: boolean = false;

  constructor(
    public modal: SuiModal<IProfileDeletedModalContext, void>,
    private userService: UserService,
    private authService: AuthService,
    private alertService: AlertService,
    private dialogService: DialogService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.isOwnProfile = this.authService.getCurrentUserId() === this.user.id;
  }

  delete() {
    this.dialogService.confirm('Confirmer la suppression ?').subscribe(value => {
      if (! value) {
        this.modal.deny(undefined);
        return;
      }

      this.performDelete();
    });
  }

  private performDelete() {
    this.loading = true;

    this.userService.deleteUser(this.user).subscribe(
      () => {
        if (this.isOwnProfile) {
          this.authService.logout();
          this.router.navigate(['']);
          this.alertService.success(['Votre compte a bien été supprimé.']);
        } else {
          this.user.deletedAt = moment().format('Y-MM-DD HH:mm:ss');
          this.alertService.success(['L\'utilisateur a bien été supprimé.']);
        }

        this.loading = false;
        this.modal.approve(undefined);
      },
      errors => {
        this.modal.deny(undefined);
        this.loading = false;
      });
  }


}

export class ProfileDeleteModal extends ComponentModalConfig<IProfileDeletedModalContext, void> {

  constructor(
    user: User,
    size = ModalSize.Mini,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(ProfileDeleteModalComponent, { user });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }

}
