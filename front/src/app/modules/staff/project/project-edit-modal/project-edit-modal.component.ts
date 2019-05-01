import { Component, OnInit } from '@angular/core';
import { Project } from "../../../../core/classes/models/project";
import { ComponentModalConfig, ModalSize } from "ng2-semantic-ui";
import { Observable } from "rxjs";
import { SuiModal } from "ng2-semantic-ui";
import { ProjectService } from "../../../../core/http/project.service";
import { AlertService } from "../../../../core/services/alert.service";
import { Router } from "@angular/router";
import { first } from "rxjs/operators";
import { handleFormErrors } from "../../../../core/functions/form-error-handler";
import { FormGroup } from "@angular/forms";

export interface IProjectEditModalContext {
  title: string;
  question: string;
  project: Project;
  projectRequest: Observable<Project>;
  projectForm: FormGroup;
}

@Component({
  selector: 'app-project-edit-modal',
  templateUrl: './project-edit-modal.component.html'
})
export class ProjectEditModalComponent implements OnInit {

  project: Project = this.modal.context.project;
  projectRequest: Observable<Project> = this.modal.context.projectRequest;
  projectForm: FormGroup = this.modal.context.projectForm;

  loading: boolean = false;

  constructor(
    public modal: SuiModal<IProjectEditModalContext, void, void>,
    private projectService: ProjectService,
    private alertService: AlertService,
    private router: Router
  ) { }

  ngOnInit() {
  }

  onClick() {
    this.loading = true;

    this.projectRequest.pipe(first())
      .subscribe(
        project => {
          this.loading = false;
          this.router.navigate([`/projets/${project.id}`]);
          this.alertService.success([`Le projet ${project.name} a bien été modifié.`]);
          this.modal.approve(undefined);
        },
        errors => {
          handleFormErrors(this.projectForm, errors);
          this.loading = false;
          this.modal.deny(undefined);
        }
      )
  }

}

export class ProjectEditModal extends ComponentModalConfig<IProjectEditModalContext, void, void> {

  constructor(
    title: string,
    question: string,
    project: Project,
    projectRequest: Observable<Project>,
    projectForm: FormGroup,
    size = ModalSize.Small,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(ProjectEditModalComponent, { title, question, project, projectRequest, projectForm });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }

}
