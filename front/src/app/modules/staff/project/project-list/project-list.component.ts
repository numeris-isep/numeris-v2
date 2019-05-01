import { Component, HostListener, Input, OnInit } from '@angular/core';
import { PaginatedProject } from "../../../../core/classes/pagination/paginated-project";
import { ProjectService } from "../../../../core/http/project.service";
import { IPopup } from "ng2-semantic-ui";
import { Client } from "../../../../core/classes/models/client";
import { dateToISO } from "../../../../shared/utils";

@Component({
  selector: 'app-project-list',
  templateUrl: './project-list.component.html',
  styleUrls: [
    '../project.component.css',
    '../../mission/mission-list/mission-list.component.scss',
  ]
})
export class ProjectListComponent implements OnInit {

  @HostListener('window:resize', ['$event'])
  onResize(event) {
    this.windowWidth = event.target.innerWidth;
  }

  windowWidth: number = window.innerWidth;

  @Input() client: Client = null;
  paginatedProject: PaginatedProject;
  selectedStep: string;
  from: string;
  to: string;
  loading: boolean = false;
  options: string[] = [
    "Ouvert", "Validé",
    "Facturé", "Payé", "Cloturé"
  ];
  stepTranslations: string[] = [
    'hiring', 'validated',
    'billed', 'paid',
    'closed'
  ];
  constructor(private projectService: ProjectService) { }

  ngOnInit() {
    this.getProjectsPerPage(1);
  }

  reset(field: string) {
    if (this[field] !== undefined) this[field] = null;
    if (field == 'selectedStep') this.setFilter();
  }

  getProjectsPerPage(pageId?: number) {
    this.loading = true;
    this.projectService.getProjectsPerPage(
      this.client,
      pageId,
      this.selectedOptionToStep(),
      [dateToISO(this.from), dateToISO(this.to)]
    ).subscribe(paginatedProject => {
      this.paginatedProject = paginatedProject;
      this.loading = false;
    });
  }

  setFilter() {
    if (this.selectedStep !== undefined
      || this.from !== undefined
      || this.to !== undefined
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

  togglePopup(popup: IPopup, condition) {
    const widthCondition = this.windowWidth >= 1287
      || (this.windowWidth < 1200 && this.windowWidth > 1093);

    if (condition && widthCondition) {
      popup.toggle();
    }
  }

}
