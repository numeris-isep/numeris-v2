import { Component, Input, OnInit } from '@angular/core';
import { Application, ApplicationStatus } from '../../../../../core/classes/models/application';
import { ApplicationService } from '../../../../../core/http/application.service';
import { AlertService } from '../../../../../core/services/alert.service';
import { ApplicationHandlerService } from '../../../../../core/services/handlers/application-handler.service';
import { Mission } from '../../../../../core/classes/models/mission';
import { CdkDragDrop } from '@angular/cdk/drag-drop';

@Component({
  selector: 'app-application-list',
  templateUrl: './application-list.component.html',
  styleUrls: [
    'application-list.component.scss',
    '../../../project/project.component.css'
  ]
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
  ) { }

  ngOnInit() {
    this.getApplications();
  }

  drop(event: CdkDragDrop<Application[]>) {
    if (event.container.id !== event.item.data.status) {
      this.updateApplication(event.container.id, event.item.data as Application);
    }
  }

  getApplications() {
    this.applicationHandler.getApplications(this.status.status).subscribe(applications => this.applications = applications);
  }

  updateApplication(status: string, application: Application) {
    this.loading = true;
    const previousStatus = application.status;

    this.applicationHandler.setApplication(status, application); // Handle application in frontend

    if (previousStatus === 'accepted') {
      Object.assign(application, { bills: []});
    }

    this.applicationService.updateApplication(status, application).subscribe(
      () => {
        this.loading = false;
      },
      () => {
        this.applicationHandler.setApplication(previousStatus, application); // Handle application in frontend
        this.loading = false;
      }
    );
  }

}
