import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['../mission/mission.component.css']
})
export class UserComponent implements OnInit {

  search: string;
  selectedUserType: string;
  selectedPromotion: string;

  constructor() { }

  ngOnInit() {
  }

  reset(field: string) {
    this[field] = null;
  }

}