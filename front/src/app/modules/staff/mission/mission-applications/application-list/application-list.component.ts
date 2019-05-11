import { Component, Input, OnInit } from '@angular/core';
import { Application, ApplicationStatus } from "../../../../../core/classes/models/application";
import { ApplicationService } from "../../../../../core/http/application.service";
import { AlertService } from "../../../../../core/services/alert.service";
import { ApplicationHandlerService } from "../../../../../core/services/handlers/application-handler.service";
import { Mission } from "../../../../../core/classes/models/mission";

@Component({
  selector: 'app-application-list',
  templateUrl: './application-list.component.html',
  styleUrls: ['../../../project/project.component.css']
})
export class ApplicationListComponent implements OnInit {

  @Input() statuses: ApplicationStatus[];
  @Input() status: ApplicationStatus;
  @Input() mission: Mission;

  applications: Application[];

  loading: boolean = false;

  constructor(
    private applicationService: ApplicationService,
    private applicationHandler: ApplicationHandlerService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.getApplications();
  }

  getApplications() {
    this.applicationHandler.getApplications(this.status.status).subscribe(applications => this.applications = applications);
  }

  updateApplication(status: string, application: Application) {
    this.loading = true;
    this.applicationService.updateApplication(status, application).subscribe(
      () => {
        // Here we know that the application is in the new list on a backend look.
        // Now we need to do the same on the front end
        this.applicationHandler.setApplication(status, application); // Handle application in frontend
        this.loading = false;
      },
      errors => {
        this.alertService.error(errors.status || errors);
        this.loading = false;
      }
    )
  }

}
