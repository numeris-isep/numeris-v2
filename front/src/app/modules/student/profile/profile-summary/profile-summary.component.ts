import { Component, Input, OnInit } from '@angular/core';
import { User } from "../../../../core/classes/models/user";

@Component({
  selector: 'app-profile-summary',
  templateUrl: './profile-summary.component.html'
})
export class ProfileSummaryComponent implements OnInit {

  @Input() user: User;

  constructor() { }

  ngOnInit() {
  }

}
