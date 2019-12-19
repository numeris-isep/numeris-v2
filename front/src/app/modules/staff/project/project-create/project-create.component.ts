import { Component, OnInit, ViewChild } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { ProjectFormComponent } from '../project-form/project-form.component';
import { handleFormDeactivation } from '../../../../core/functions/form-deactivate-handler';

@Component({
  selector: 'app-project-create',
  templateUrl: './project-create.component.html'
})
export class ProjectCreateComponent implements OnInit, CanComponentDeactivate {

  @ViewChild(ProjectFormComponent) projectFormComponent: ProjectFormComponent;

  constructor(
    private route: ActivatedRoute,
    private breadcrumbsService: BreadcrumbsService
  ) { }

  ngOnInit() {
    this.breadcrumbsService.setBreadcrumb(
      this.route.snapshot,
      { title: 'Nouveau projet', url: '' }
    );
  }

  canDeactivate() {
    return handleFormDeactivation(this.projectFormComponent, 'projectForm');
  }

}
