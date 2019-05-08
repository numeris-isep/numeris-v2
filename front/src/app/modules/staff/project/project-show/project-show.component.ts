import { Component, OnInit } from '@angular/core';
import { Project, ProjectStep } from "../../../../core/classes/models/project";
import { ActivatedRoute } from "@angular/router";
import { ProjectService } from "../../../../core/http/project.service";
import { TitleService } from "../../../../core/services/title.service";
import { BreadcrumbsService } from "../../../../core/services/breadcrumbs.service";
import { AlertService } from "../../../../core/services/alert.service";
import { dateToString } from "../../../../shared/utils";

@Component({
  selector: 'app-project-show',
  templateUrl: './project-show.component.html',
  styleUrls: ['./project-show.component.css']
})
export class ProjectShowComponent implements OnInit {

  project: Project;
  steps: ProjectStep[];

  selectedStep: string;
  currentDate: string;
  loading: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private projectService: ProjectService,
    private titleService: TitleService,
    private breadcrumbService: BreadcrumbsService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.getProjectSteps();
    this.route.params.subscribe(param => {
      this.getProject(parseInt(param.id));
    });
  }

  getProject(projectId: number) {
    return this.projectService.getProject(projectId).subscribe(project => {
      this.project = project;
      this.selectedStep = project.step;

      this.titleService.setTitles(project.name);
      this.breadcrumbService.setBreadcrumb(
        this.route.snapshot,
        { title: project.name, url: ''}
      )
    });
  }

  getProjectSteps() {
    this.projectService.getProjectSteps().subscribe(steps => this.steps = steps);
  }

  updateStep() {
    this.projectService.updateProjectStep(this.selectedStep, this.project).subscribe(
      () => {
        this.project.step = this.selectedStep;
        this.alertService.success(['Status du projet mis à jour.']);
      },
      errors => this.alertService.error(errors.step || errors)
    )
  }

  updatePayment() {
    this.currentDate = dateToString(new Date());

    this.projectService.updateProjectPayment(this.currentDate, this.project).subscribe(
      () => {
        this.project.moneyReceivedAt = this.currentDate;
        this.alertService.success(['Paiement marqué comme reçu.']);
      },
      errors => this.alertService.error(errors.money_received_at || errors)
    )
  }

}
