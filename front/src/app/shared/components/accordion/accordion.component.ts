import { Component, Input, OnInit } from '@angular/core';
import { SidebarComponent } from "../../../core/components/sidebar/sidebar.component";

@Component({
  selector: 'app-accordion',
  templateUrl: './accordion.component.html'
})
export class AccordionComponent implements OnInit {

  @Input() sidebar: SidebarComponent;

  constructor() { }

  ngOnInit() {
  }

}
