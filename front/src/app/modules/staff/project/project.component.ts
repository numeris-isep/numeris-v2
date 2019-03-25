import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-project',
  templateUrl: './project.component.html',
  styleUrls: ['../mission/mission.component.css']
})
export class ProjectComponent implements OnInit {

  selectedStep: string;
  minDate: string;
  maxDate: string;

  constructor() { }

  ngOnInit() {
  }

  reset(field: string) {
    this[field] = null;
  }

}
