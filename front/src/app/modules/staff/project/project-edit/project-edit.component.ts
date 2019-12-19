import { Component, OnInit, ViewChild } from '@angular/core';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { ActivatedRoute } from '@angular/router';
import { ProjectService } from '../../../../core/http/project.service';
import { Project } from '../../../../core/classes/models/project';
import { ProjectFormComponent } from '../project-form/project-form.component';
import { handleFormDeactivation } from '../../../../core/functions/form-deactivate-handler';

@Component({
  selector: 'app-project-edit',
  templateUrl: './project-edit.component.html'
})
export class ProjectEditComponent implements OnInit {

  @ViewChild(ProjectFormComponent) projectFormComponent: ProjectFormComponent;

  project: Project;

  constructor(
    private route: ActivatedRoute,
    private projectService: ProjectService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getProject(parseInt(param.projectId));
    });
  }

  canDeactivate() {
    return handleFormDeactivation(this.projectFormComponent, 'projectForm');
  }

  getProject(projectId: number) {
    return this.projectService.getProject(projectId).subscribe(project => {
      this.project = project;

      this.titleService.setTitles(`${project.name} - Modifier`);
      this.breadcrumbsService.setBreadcrumb(
        this.route.snapshot,
        [{ title: project.name, url: `/projets/${project.id}` }, { title: 'Modifier', url: '' }]
      );
    });
  }

}
