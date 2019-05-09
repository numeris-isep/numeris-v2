import { Component, HostListener, Input, OnDestroy, OnInit } from '@angular/core';
import { PaginatedUser } from "../../../../core/classes/pagination/paginated-user";
import { FormControl } from "@angular/forms";
import { Observable, Subscription } from "rxjs";
import { UserService } from "../../../../core/http/user.service";
import { debounceTime } from "rxjs/operators";
import { IPopup } from "ng2-semantic-ui";
import { Project } from "../../../../core/classes/models/project";
import { Mission } from "../../../../core/classes/models/mission";
import { RoleService } from "../../../../core/http/role.service";
import { Role } from "../../../../core/classes/models/role";
import { ApplicationService } from "../../../../core/http/application.service";
import { User } from 'src/app/core/classes/models/user';
import { AlertService } from "../../../../core/services/alert.service";
import { ApplicationHandlerService } from "../../../../core/services/application-handler.service";

@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: [
    '../../project/project.component.css',
    '../../mission/mission-list/mission-list.component.scss'
  ]
})
export class UserListComponent implements OnInit, OnDestroy {

  @HostListener('window:resize', ['$event'])
  onResize(event) {
    this.windowWidth = event.target.innerWidth;
  }

  windowWidth: number = window.innerWidth;

  @Input() page: string = "user-list";
  @Input() project: Project = null;
  @Input() mission: Mission = null;
  paginatedUser: PaginatedUser;
  search: string = '';
  searchControl: FormControl = new FormControl();
  searchControlSubscription: Subscription;
  selectedRole: string;
  selectedPromotion: string;
  roles: Role[];
  promotions: string[];
  loading: boolean = false;

  constructor(
    private alertService: AlertService,
    private userService: UserService,
    private roleService: RoleService,
    private applicationService: ApplicationService,
    private applicationHandlerService: ApplicationHandlerService,
  ) { }

  ngOnInit() {
    this.searchControlSubscription = this.searchControl.valueChanges.pipe(
      debounceTime(400)
    ).subscribe(value => {
      this.search = value;
      this.setFilter();
    });
    this.getUsersPerPage(1);
    this.getRoles();
    this.getPromotions();
  }

  ngOnDestroy() {
    this.searchControlSubscription.unsubscribe()
  }

  reset(field: string) {
    if (this[field] !== undefined) this[field] = null;
    if (field == 'search') this.getUsersPerPage(1);
    this.setFilter();
  }

  getUsersPerPage(pageId?: number) {
    this.loading = true;
    let results: Observable<PaginatedUser>;

    if (this.page != 'mission-show') {
      results = this.userService.getUsersPerPage(
        this.project, pageId, this.search,
        this.selectedRole, this.selectedPromotion
      );
    } else {
      results = this.userService.getMissionUsersPerPage(
        this.mission, pageId, this.search,
        this.selectedRole, this.selectedPromotion,
      );
    }

    results.subscribe(
      paginatedUser => {
      this.paginatedUser = paginatedUser;
      this.loading = false;
    },
      error => {}
    );
  }

  getRoles() {
    this.roleService.getRoles().subscribe(roles => this.roles = roles);
  }

  getPromotions() {
    this.userService.getPromotions().subscribe(promotions => this.promotions = promotions);
  }

  setFilter() {
    if (this.search !== undefined && this.search != null && this.search == this.search.trim()
      || this.selectedRole !== undefined
      || this.selectedPromotion !== undefined
    ) {
      console.log(this.selectedRole);
      this.getUsersPerPage(1);
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
        this.paginatedUser.data = this.paginatedUser.data.filter(u => u !== user);
        this.applicationHandlerService.setApplication('accepted', application); // Handle application in frontend
        this.loading = false;
      },
      errors => {
        this.alertService.error(errors);
        this.loading = false;
      }
    )
  }

}
