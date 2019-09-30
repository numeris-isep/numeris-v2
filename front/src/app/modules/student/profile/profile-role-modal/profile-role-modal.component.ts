import { Component, OnInit } from '@angular/core';
import { ComponentModalConfig, ModalSize } from 'ng2-semantic-ui';
import { User } from '../../../../core/classes/models/user';
import { SuiModal } from 'ng2-semantic-ui';
import { RoleService } from '../../../../core/http/role.service';
import { Role } from '../../../../core/classes/models/role';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { RolePipe } from '../../../../shared/pipes/role.pipe';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';
import { AlertService } from '../../../../core/services/alert.service';
import { AuthService } from '../../../../core/http/auth/auth.service';
import { Router } from '@angular/router';

export interface IProfileRoleModalContext {
  user: User;
}

@Component({
  selector: 'app-profile-role-modal',
  templateUrl: './profile-role-modal.component.html',
  styleUrls: ['./profile-role-modal.component.css']
})
export class ProfileRoleModalComponent implements OnInit {

  user: User = this.modal.context.user;
  roles: Role[];
  roleForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;
  isOwnProfile: boolean;

  constructor(
    public modal: SuiModal<IProfileRoleModalContext, void>,
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private roleService: RoleService,
    private alertService: AlertService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.isOwnProfile = this.authService.getCurrentUserId() === this.user.id;
    this.getRoles();
    this.initForm();
  }

  initForm() {
    this.roleForm = this.formBuilder.group({
      role: [null, Validators.required],
    });
  }

  getRoles() {
    this.roleService.getRoles().subscribe(roles => this.roles = roles);
  }

  translateRole(role: Role): string {
    return (new RolePipe).transform(role);
  }

  get f() { return this.roleForm.controls; }

  onSubmit() {
    this.submitted = true;

    // stop here if form is invalid
    if (this.roleForm.invalid) { return; }

    this.loading = true;

    this.roleService.addRole(this.roleForm.value.role, this.user)
      .subscribe(
        role => {
          this.user.roles.unshift(role);
          this.alertService.success([
            (this.isOwnProfile ? 'Vous avez' : `L\'utilisateur ${this.user.firstName} ${this.user.lastName.toUpperCase()} a`)
            + ` été promu ${this.translateRole(role)}`
          ]);

          if (this.isOwnProfile) {
            this.authService.logout();
            this.router.navigate([''], { queryParams: { returnUrl: 'profil'} });
          }

          this.loading = false;
          this.modal.approve(undefined);
        },
        errors => {
          handleFormErrors(this.roleForm, errors);
          this.loading = false;
        }
      );
  }

}

export class ProfileRoleModal extends ComponentModalConfig<IProfileRoleModalContext, void> {

  constructor(
    user: User,
    size = ModalSize.Small,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(ProfileRoleModalComponent, { user });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }

}
