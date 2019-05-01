import { Component, OnInit } from '@angular/core';
import { Project } from "../../../../core/classes/models/project";
import { ComponentModalConfig, ModalSize } from "ng2-semantic-ui";
import { Observable } from "rxjs";
import { SuiModal } from "ng2-semantic-ui";
import { ProjectService } from "../../../../core/http/project.service";
import { AlertService } from "../../../../core/services/alert.service";
import { Router } from "@angular/router";

export interface IProjectDeleteModalContext {
  title: string;
  question: string;
  project: Project
}

@Component({
  selector: 'app-delete-project-modal',
  templateUrl: './project-delete-modal.component.html'
})
export class ProjectDeleteModalComponent implements OnInit {

  project: Project = this.modal.context.project;

  loading: boolean = false;

  constructor(
    public modal: SuiModal<IProjectDeleteModalContext, void>,
    private projectService: ProjectService,
    private alertService: AlertService,
    private router: Router
  ) { }

  ngOnInit() {
  }

  onClick() {
    this.loading = true;

    this.deleteProject().subscribe(
      () => {
        this.router.navigate(['/projets']);
        this.alertService.success([`Le projet ${this.project.name} a bien été supprimé.`]);
        this.modal.approve(undefined);
      },
      error => {
        this.modal.deny(undefined);
      }
    )
  }

  deleteProject(): Observable<Project> {
    return this.projectService.deleteProject(this.project);
  }

}

export class ProjectDeleteModal extends ComponentModalConfig<IProjectDeleteModalContext, void> {

  constructor(
    title: string,
    question: string,
    project: Project,
    size = ModalSize.Small,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(ProjectDeleteModalComponent, { title, question, project });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }

}
