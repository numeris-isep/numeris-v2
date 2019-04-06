import { Component, Input, OnInit } from '@angular/core';
import { Project } from "../../../../core/classes/models/project";

@Component({
  selector: 'app-project-details',
  templateUrl: './project-details.component.html',
  styleUrls: [
    './../project.component.css',
    '../../client/client-details/client-details.component.css'
  ]
})
export class ProjectDetailsComponent implements OnInit {

  @Input() project: Project;

  constructor() { }

  ngOnInit() {
  }

}
