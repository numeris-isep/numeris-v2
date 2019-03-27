import { Component, OnInit } from '@angular/core';
import { ProjectService } from "../../../core/http/project.service";
import * as moment from "moment";
import { PaginatedProject } from "../../../core/classes/pagination/paginated-project";

@Component({
  selector: 'app-project',
  templateUrl: './project.component.html',
  styleUrls: ['../mission/mission.component.css']
})
export class ProjectComponent implements OnInit {

  paginatedProject: PaginatedProject;
  selectedStep: string;
  minDate: string;
  maxDate: string;
  loading: boolean = false;
  options = [
    "Ouvert", "Validé",
    "Facturé", "Payé", "Cloturé"
  ];
  stepTranslations = [
    'hiring', 'validated',
    'billed', 'paid',
    'closed'
  ];
  constructor(private projectService: ProjectService) { }

  ngOnInit() {
    this.getProjectsPerPage(1);
  }

  reset(field: string) {
    this[field] = null;
    if (field == 'selectedStep') this.setFilter();
  }

  getProjectsPerPage(pageId?: number) {
    this.loading = true;
    this.projectService.getProjectsPerPage(
      pageId,
      this.selectedOptionToStep(),
      [this.dateToISO(this.minDate), this.dateToISO(this.maxDate)]
    ).subscribe(paginatedProject => {
      this.paginatedProject = paginatedProject;
      this.loading = false;
    });
  }

  setFilter() {
    if (this.selectedStep !== undefined
      || this.minDate !== undefined
      || this.maxDate !== undefined
    ) {
      this.getProjectsPerPage(1);
    }
  }

  selectedOptionToStep() {
    if (this.selectedStep !== undefined && this.selectedStep !== null) {
      const key = Object.keys(this.options)
        .find(key => this.options[key] === this.selectedStep);

      return this.stepTranslations[key];
    }

    return this.selectedStep;
  }

  dateToISO(date: string) {
    return date ? moment(date).toISOString() : null;
  }
}
