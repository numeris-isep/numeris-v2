import { Component, OnInit, ViewChild } from '@angular/core';
import { Project } from 'src/app/core/classes/models/project';
import { ActivatedRoute } from '@angular/router';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { ProjectService } from '../../../../core/http/project.service';
import { MissionFormComponent } from '../../mission/mission-form/mission-form.component';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { equals } from '../../../../shared/utils';

@Component({
  selector: 'app-project-mission-create',
  templateUrl: './project-mission-create.component.html'
})
export class ProjectMissionCreateComponent implements OnInit, CanComponentDeactivate {

  @ViewChild(MissionFormComponent) missionFormComponent: MissionFormComponent;

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
    });
  }

  canDeactivate() {
    try {
      return equals(
        this.missionFormComponent.initialValue,
        this.missionFormComponent.missionForm.value
      );
    } catch (e) {
      return true;
    }
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
