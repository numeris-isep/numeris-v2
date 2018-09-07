import { Component, Input, OnInit } from '@angular/core';
import { SidebarComponent } from "../sidebar.component";
import { Observable } from "rxjs";

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html'
})
export class MenuComponent implements OnInit {

  @Input() isLoggedIn$: Observable<boolean>;
  @Input() sidebar : SidebarComponent;

  constructor() {}

  ngOnInit() {
  }

}
