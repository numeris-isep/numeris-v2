import { Component, Input, OnInit } from '@angular/core';
import { Application, ApplicationStatus } from "../../../../../core/classes/models/application";
import { ApplicationService } from "../../../../../core/http/application.service";
import { AlertService } from "../../../../../core/services/alert.service";

@Component({
  selector: 'app-application-list',
  templateUrl: './application-list.component.html',
  styleUrls: ['../../../project/project.component.css']
})
export class ApplicationListComponent implements OnInit {

  @Input() applications: Application[];
  @Input() statuses: ApplicationStatus[];
  @Input() status: ApplicationStatus;

  loading: boolean = false;

  constructor(
    private applicationService: ApplicationService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
  }

  updateApplication(status: string, application: Application) {
    this.loading = true;
    this.applicationService.updateApplication(status, application).subscribe(
      () => {
        this.applications = this.applications.filter(a => a !== application);

        const statusTranslation = this.statuses.filter(object => object.status === status)[0].translation;
        this.alertService.success([`Candidature de l'utilisateur ${application.user.firstName} ${application.user.lastName.toUpperCase()} marquée comme ${statusTranslation}.`]);
        this.loading = false;
      },
      errors => {
        this.alertService.error(errors.status || errors);
        this.loading = false;
      }
    )
  }

}
