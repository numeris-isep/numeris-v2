import { Component, OnInit } from '@angular/core';
import { Project } from 'src/app/core/classes/models/project';
import { ActivatedRoute } from "@angular/router";
import { TitleService } from "../../../../core/services/title.service";
import { BreadcrumbsService } from "../../../../core/services/breadcrumbs.service";
import { ProjectService } from "../../../../core/http/project.service";

@Component({
  selector: 'app-project-mission-create',
  templateUrl: './project-mission-create.component.html'
})
export class ProjectMissionCreateComponent implements OnInit {

  project: Project;

  constructor(
    private route: ActivatedRoute,
    private projectService: ProjectService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService,
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getProject(parseInt(param.projectId));
    })
  }

  getProject(projectId: number) {
    return this.projectService.getProject(projectId).subscribe(
      project => {
        this.project = project;

        this.titleService.setTitles(`${project.name} - Nouvelle mission`);
        this.breadcrumbsService.setBreadcrumb(
          this.route.snapshot,
          [{ title: project.name, url: `/projets/${project.id}` }, { title: 'Nouvelle mission', url: '' }]
        );
      },
      errors => {},
    );
  }

}
