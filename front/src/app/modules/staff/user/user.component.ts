import { Component, HostListener, OnDestroy, OnInit } from '@angular/core';
import { PaginatedUser } from "../../../core/classes/pagination/paginated-user";
import { UserService } from "../../../core/http/user.service";
import { IPopup } from "ng2-semantic-ui";
import { debounceTime } from "rxjs/operators";
import { FormControl } from "@angular/forms";
import { Subscription } from "rxjs";

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['../mission/mission-list/mission-list.component.scss']
})
export class UserComponent implements OnInit, OnDestroy {

  @HostListener('window:resize', ['$event'])
  onResize(event) {
    this.windowWidth = event.target.innerWidth;
  }

  windowWidth: number = window.innerWidth;
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
      debounceTime(1000)
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
    this.loading = true;
    this.userService.getUsersPerPage(
      pageId,
      this.search,
      this.selectedRoleToRole(),
      this.selectedPromotion,
    ).subscribe(paginatedUser => {
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
      this.getUsersPerPage(1);
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
