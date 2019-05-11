import { Component, OnDestroy, OnInit } from '@angular/core';
import { Project, ProjectStep } from "../../../../core/classes/models/project";
import { ActivatedRoute } from "@angular/router";
import { ProjectService } from "../../../../core/http/project.service";
import { TitleService } from "../../../../core/services/title.service";
import { BreadcrumbsService } from "../../../../core/services/breadcrumbs.service";
import { AlertService } from "../../../../core/services/alert.service";
import { dateToString } from "../../../../shared/utils";
import { ProjectUserModal } from "../project-user-modal/project-user-modal.component";
import { SuiModalService } from "ng2-semantic-ui";
import { ProjectUserHandlerService } from "../../../../core/services/handlers/project-user-handler.service";
import { User } from 'src/app/core/classes/models/user';
import { BehaviorSubject } from "rxjs";

@Component({
  selector: 'app-project-show',
  templateUrl: './project-show.component.html',
  styleUrls: ['./project-show.component.css']
})
export class ProjectShowComponent implements OnInit, OnDestroy {

  project: Project;
  steps: ProjectStep[];
  projectUsers: User[] = [];

  selectedStep: string;
  currentDate: string;
  loading: boolean = false;

  projectUserModal: ProjectUserModal;

  constructor(
    private route: ActivatedRoute,
    private projectService: ProjectService,
    private titleService: TitleService,
    private breadcrumbService: BreadcrumbsService,
    private alertService: AlertService,
    private modalService: SuiModalService,
    private projectUserHandler: ProjectUserHandlerService,
  ) { }

  ngOnInit() {
    this.getProjectSteps();
    this.route.params.subscribe(param => {
      this.getProject(parseInt(param.id));
    });
  }

  ngOnDestroy() {
    this.projectUserHandler.resetAll();
  }

  getProject(projectId: number) {
    return this.projectService.getProject(projectId).subscribe(project => {
      this.project = project;
      this.selectedStep = project.step;

      this.titleService.setTitles(project.name);
      this.breadcrumbService.setBreadcrumb(
        this.route.snapshot,
        { title: project.name, url: ''}
      );

      if (this.project.isPrivate) {
        this.projectUserModal = new ProjectUserModal(this.project);
        this.watchProjectUsers();
        this.getProjectUsers();
      }
    });
  }

  watchProjectUsers() {
    this.projectUserHandler.watchProjectUsers(this.project);
  }

  getProjectUsers() {
    this.projectUserHandler.getProjectUsers().subscribe(users => this.projectUsers = users);
  }

  getProjectSteps() {
    this.projectService.getProjectSteps().subscribe(steps => this.steps = steps);
  }

  updateStep() {
    this.projectService.updateProjectStep(this.selectedStep, this.project).subscribe(
      () => this.project.step = this.selectedStep,
      errors => this.alertService.error(errors.step || errors)
    )
  }

  updatePayment() {
    this.currentDate = dateToString(new Date());

    this.projectService.updateProjectPayment(this.currentDate, this.project).subscribe(
      () => this.project.moneyReceivedAt = this.currentDate,
      errors => this.alertService.error(errors.money_received_at || errors)
    )
  }

  openModal() {
    this.modalService.open(this.projectUserModal);
  }

}
