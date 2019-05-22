import { Component, Input, OnInit } from '@angular/core';
import { Mission } from '../../../../core/classes/models/mission';
import { Application } from '../../../../core/classes/models/application';

@Component({
  selector: 'app-mission-bills',
  templateUrl: './mission-bills.component.html'
})
export class MissionBillsComponent implements OnInit {

  @Input() mission: Mission;
  @Input() applications: Application[];

  constructor() { }

  ngOnInit() {
  }

}
