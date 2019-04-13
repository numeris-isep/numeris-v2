import { Component, HostListener, Input, OnDestroy, OnInit } from '@angular/core';
import { PaginatedUser } from "../../../../core/classes/pagination/paginated-user";
import { FormControl } from "@angular/forms";
import { Observable, Subscription } from "rxjs";
import { UserService } from "../../../../core/http/user.service";
import { debounceTime } from "rxjs/operators";
import { IPopup } from "ng2-semantic-ui";
import { Project } from "../../../../core/classes/models/project";
import { Mission } from "../../../../core/classes/models/mission";

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
  roles: string[] = [
    "Étudiant", "Staff",
    "Administrateur", "Développeur"
  ];
  roleTranslations: string[] = [
    'student', 'staff',
    'administrator', 'developer'
  ];
  promotions: string[];
  loading: boolean = false;

  constructor(private userService: UserService) { }

  ngOnInit() {
    this.searchControlSubscription = this.searchControl.valueChanges.pipe(
      debounceTime(400)
    ).subscribe(value => {
      this.search = value;
      this.setFilter();
    });
    this.getUsersPerPage(1);
    this.getPromotions();
  }

  ngOnDestroy() {
    this.searchControlSubscription.unsubscribe()
  }

  reset(field: string) {
    if (this[field] !== undefined) this[field] = null;
    this.setFilter();
  }

  getUsersPerPage(pageId?: number) {
    console.log(this.search);
    this.loading = true;
    let results: Observable<PaginatedUser>;

    if (this.page != 'mission-show') {
      results = this.userService.getUsersPerPage(
        this.project, pageId, this.search,
        this.selectedRoleToRole(), this.selectedPromotion
      );
    } else {
      results = this.userService.getMissionUsersPerPage(
        this.mission, pageId, this.search,
        this.selectedRoleToRole(), this.selectedPromotion,
      );
    }

    results.subscribe(paginatedUser => {
      this.paginatedUser = paginatedUser;
      this.loading = false;
    });
  }

  getPromotions() {
    this.userService.getPromotions().subscribe(promotions => {this.promotions = promotions})
  }

  setFilter() {
    if (this.search !== undefined
      || this.selectedRole !== undefined
      || this.selectedPromotion !== undefined
    ) {
      if (this.search === null) {
        this.getUsersPerPage(1);
      } else if (this.search.trim() != '') {
        this.getUsersPerPage(1);
      }
    }
  }

  selectedRoleToRole() {
    if (this.selectedRole !== undefined && this.selectedRole !== null) {
      const key = Object.keys(this.roles)
        .find(key => this.roles[key] === this.selectedRole);

      return this.roleTranslations[key];
    }

    return this.selectedRole;
  }

  togglePopup(popup: IPopup, condition) {
    const widthCondition = this.windowWidth >= 1287
      || (this.windowWidth < 1200 && this.windowWidth > 1093);

    if (condition && widthCondition) {
      popup.toggle();
    }
  }

}
