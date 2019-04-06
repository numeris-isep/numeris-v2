import { Component, OnInit } from '@angular/core';
import { Project } from "../../../../core/classes/models/project";
import { ActivatedRoute } from "@angular/router";
import { ProjectService } from "../../../../core/http/project.service";
import { TitleService } from "../../../../core/services/title.service";
import { BreadcrumbsService } from "../../../../core/services/breadcrumbs.service";

@Component({
  selector: 'app-project-show',
  templateUrl: './project-show.component.html',
  styleUrls: ['./project-show.component.css']
})
export class ProjectShowComponent implements OnInit {

  project: Project;
  options: string[] = [
    "Ouvert", "Validé",
    "Facturé", "Payé", "Cloturé"
  ];

  constructor(
    private route: ActivatedRoute,
    private projectService: ProjectService,
    private titleService: TitleService,
    private breadcrumbService: BreadcrumbsService
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getProject(parseInt(param.id));
    });
  }

  getProject(projectId: number) {
    return this.projectService.getProject(projectId).subscribe(project => {
      this.project = project;

      this.titleService.setTitles(project.name);
      this.breadcrumbService.setBreadcrumb(
        this.route.snapshot,
        { title: project.name, url: ''}
      )
    });
  }

}
