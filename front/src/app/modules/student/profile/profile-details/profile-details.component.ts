import { Component, Input, OnInit } from '@angular/core';
import { User } from "../../../../core/classes/models/user";

@Component({
  selector: 'app-profile-details',
  templateUrl: './profile-details.component.html'
})
export class ProfileDetailsComponent implements OnInit {

  @Input() user: User;

  constructor() { }

  ngOnInit() {
  }

}
