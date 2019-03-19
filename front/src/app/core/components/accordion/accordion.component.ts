import { Component, Input, OnInit } from '@angular/core';
import { SidebarComponent } from "../sidebar/sidebar.component";
import * as moment from 'moment';

@Component({
  selector: 'app-accordion',
  templateUrl: './accordion.component.html'
})
export class AccordionComponent implements OnInit {

  currentYear = moment().year();

  @Input() sidebar: SidebarComponent;

  constructor() { }

  ngOnInit() {
  }

}
