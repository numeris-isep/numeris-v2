import { Component, HostListener, Input, OnDestroy, OnInit } from '@angular/core';
import { PaginatedUser } from '../../../../core/classes/pagination/paginated-user';
import { FormControl } from '@angular/forms';
import { Observable, Subscription } from 'rxjs';
import { UserService } from '../../../../core/http/user.service';
import { debounceTime } from 'rxjs/operators';
import { IPopup } from 'ng2-semantic-ui';
import { Project } from '../../../../core/classes/models/project';
import { Mission } from '../../../../core/classes/models/mission';
import { RoleService } from '../../../../core/http/role.service';
import { Role } from '../../../../core/classes/models/role';
import { ApplicationService } from '../../../../core/http/application.service';
import { User } from 'src/app/core/classes/models/user';
import { AlertService } from '../../../../core/services/alert.service';
import { ApplicationHandlerService } from '../../../../core/services/handlers/application-handler.service';
import { ProjectUserHandlerService } from '../../../../core/services/handlers/project-user-handler.service';
import { ProjectService } from '../../../../core/http/project.service';

@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: [
    '../../project/project.component.css',
    '../../mission/mission-list/mission-list.component.scss'
  ]
})
export class UserListComponent implements OnInit, OnDestroy {

  windowWidth: number = window.innerWidth;

  @Input() page = 'user-list';
  @Input() project: Project = null;
  @Input() mission: Mission = null;
  paginatedUser: PaginatedUser;
  search = '';
  searchControl: FormControl = new FormControl();
  searchControlSubscription: Subscription;
  selectedRole: string;
  selectedPromotion: string;
  roles: Role[];
  promotions: string[];
  loading = false;

  @HostListener('window:resize', ['$event'])
  onResize(event) {
    this.windowWidth = event.target.innerWidth;
  }

  constructor(
    private alertService: AlertService,
    private userService: UserService,
    private roleService: RoleService,
    private applicationService: ApplicationService,
    private projectService: ProjectService,
    private applicationHandler: ApplicationHandlerService,
    private projectUserHandler: ProjectUserHandlerService,
  ) { }

  ngOnInit() {
    this.searchControlSubscription = this.searchControl.valueChanges.pipe(
      debounceTime(400)
    ).subscribe(value => {
      this.search = value;
      this.setFilter();
    });
    this.getPaginatedUsers(1);
    this.getRoles();
    this.getPromotions();

    if (this.project) {
      this.getProjectUsers();
    }
  }

  ngOnDestroy() {
    this.searchControlSubscription.unsubscribe();
  }

  reset(field: string) {
    if (this[field] !== undefined) { this[field] = null; }
    if (field === 'search') { this.getPaginatedUsers(1); }
    this.setFilter();
  }

  getProjectUsers() {
    return this.projectUserHandler.getProjectUsersSubject().subscribe(() => this.getPaginatedUsers());
  }

  getPaginatedUsers(pageId: number = 1) {
    this.loading = true;
    let results: Observable<PaginatedUser>;

    switch (this.page) {
      case 'mission-show':
        results = this.userService.getPaginatedMissionUsers(
          this.mission, pageId, this.search,
          this.selectedRole, this.selectedPromotion,
        );
        break;
      case 'project-user-modal':
        results = this.userService.getPaginatedUsersNotInProject(
          this.project, pageId, this.search,
          this.selectedRole, this.selectedPromotion
        );
        break;
      default:
        results = this.userService.getPaginatedUsers(
          this.project, pageId, this.search,
          this.selectedRole, this.selectedPromotion
        );
        break;
    }

    results.subscribe(
      paginatedUser => {
      this.paginatedUser = paginatedUser;
      this.loading = false;
    });
  }

  getRoles() {
    this.roleService.getRoles().subscribe(roles => this.roles = roles);
  }

  getPromotions() {
    this.userService.getPromotions().subscribe(promotions => this.promotions = promotions);
  }

  setFilter() {
    if (this.search !== undefined && this.search != null && this.search === this.search.trim()
      || this.selectedRole !== undefined
      || this.selectedPromotion !== undefined
    ) {
      this.getPaginatedUsers(1);
    }
  }

  togglePopup(popup: IPopup, condition) {
    const widthCondition = this.windowWidth >= 1287
      || (this.windowWidth < 1200 && this.windowWidth > 1093);

    if (condition && widthCondition) {
      popup.toggle();
    }
  }

  enrolUser(user: User) {
    this.loading = true;
    this.applicationService.storeMissionApplication(this.mission, user).subscribe(
      application => {
        this.applicationHandler.setApplication('accepted', application); // Handle application in frontend
        this.getPaginatedUsers();
        this.loading = false;
      },
      errors => {
        this.alertService.error(errors);
        this.loading = false;
      }
    );
  }

  enrolProjectUser(user: User) {
    this.loading = true;
    this.projectService.addProjectUser(this.project, user).subscribe(
      user => {
        this.projectUserHandler.addProjectUser(user);
        this.loading = false;
      },
      errors => {
        this.alertService.error(errors);
        this.loading = false;
      }
    );
  }

  removeProjectUser(user: User) {
    this.loading = true;
    this.projectService.removeProjectUser(this.project, user).subscribe(
      () => {
        this.getPaginatedUsers();
        this.projectUserHandler.removeProjectUser(user);
        this.loading = false;
      },
      errors => {
        this.alertService.error(errors);
        this.loading = false;
      }
    );
  }

}
