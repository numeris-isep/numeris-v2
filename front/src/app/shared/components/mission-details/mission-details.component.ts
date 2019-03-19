import { Component, Input, OnInit } from '@angular/core';
import { Mission } from "../../../core/classes/models/mission";

@Component({
  selector: 'app-mission-details',
  templateUrl: './mission-details.component.html',
  styleUrls: ['./mission-details.component.css']
})
export class MissionDetailsComponent implements OnInit {

  @Input() mission: Mission;
  @Input() color: string = 'blue';

  constructor() { }

  ngOnInit() {
  }

}
