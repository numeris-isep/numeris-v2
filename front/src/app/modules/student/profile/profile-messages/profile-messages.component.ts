import { Component, Input, OnInit } from '@angular/core';
import { User } from '../../../../core/classes/models/user';

@Component({
  selector: 'app-profile-messages',
  templateUrl: './profile-messages.component.html',
  styleUrls: ['./profile-messages.component.css']
})
export class ProfileMessagesComponent implements OnInit {

  @Input() user: User;

  constructor() { }

  ngOnInit() {
  }

}
