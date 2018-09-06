import { Component, Input, OnInit } from '@angular/core';
import { SidebarComponent } from "../sidebar.component";

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html'
})
export class MenuComponent implements OnInit {

  @Input() isLoggedIn: boolean;
  @Input() sidebar : SidebarComponent;

  constructor() {}

  ngOnInit() {
  }

}
