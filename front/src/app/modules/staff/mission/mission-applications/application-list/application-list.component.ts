import { Component, Input, OnInit } from '@angular/core';
import { Application } from "../../../../../core/classes/models/application";

@Component({
  selector: 'app-application-list',
  templateUrl: './application-list.component.html',
  styleUrls: ['../../../project/project.component.css']
})
export class ApplicationListComponent implements OnInit {

  @Input() applications: Application[];
  @Input() statuses: string;

  constructor() { }

  ngOnInit() {
  }

}
