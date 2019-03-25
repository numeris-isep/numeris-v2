import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-mission',
  templateUrl: './mission.component.html',
  styleUrls: ['./mission.component.css']
})
export class MissionComponent implements OnInit {

  selectedFilter: string;
  minDate: string;
  maxDate: string;

  constructor() { }

  ngOnInit() {
  }

  reset(field: string) {
    this[field] = null;
  }

}
