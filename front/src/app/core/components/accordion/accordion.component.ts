import { Component, Input, OnInit } from '@angular/core';
import { SidebarComponent } from '../sidebar/sidebar.component';
import * as moment from 'moment';
import { AuthService } from '../../http/auth/auth.service';
import { User } from '../../classes/models/user';
import { UserService } from '../../http/user.service';
import { Count } from '../../classes/count';

@Component({
  selector: 'app-accordion',
  templateUrl: './accordion.component.html',
  styleUrls: ['./accordion.component.css'],
})
export class AccordionComponent implements OnInit {

  currentYear = moment().year();
  currentUserId: number;
  currentUserRole: string;
  currentUser: User;

  @Input() sidebar: SidebarComponent;
  @Input() counts: Count;

  constructor(
    private authService: AuthService,
    private userService: UserService,
  ) { }

  ngOnInit() {
    this.currentUserId = this.authService.getCurrentUserId();
    this.currentUserRole = this.authService.getCurrentUserRole();
    this.getCurrentUser();
  }

  getCurrentUser() {
    this.userService.getUser(this.currentUserId).subscribe(user => this.currentUser = user);
  }
}
