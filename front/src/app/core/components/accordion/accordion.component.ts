import { Component, Input, OnInit } from '@angular/core';
import { SidebarComponent } from "../sidebar/sidebar.component";
import * as moment from 'moment';
import { AuthService } from "../../http/auth/auth.service";

@Component({
  selector: 'app-accordion',
  templateUrl: './accordion.component.html'
})
export class AccordionComponent implements OnInit {

  currentYear = moment().year();
  currentUserRole: string;

  @Input() sidebar: SidebarComponent;

  constructor(private authService: AuthService) { }

  ngOnInit() {
    this.currentUserRole = this.authService.getCurrentUserRole();
  }

}
