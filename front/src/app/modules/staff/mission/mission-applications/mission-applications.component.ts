import { Component, Input, OnInit } from '@angular/core';
import { Mission } from "../../../../core/classes/models/mission";
import { Application, ApplicationStatus } from "../../../../core/classes/models/application";
import { ApplicationService } from "../../../../core/http/application.service";

@Component({
  selector: 'app-mission-applications',
  templateUrl: './mission-applications.component.html'
})
export class MissionApplicationsComponent implements OnInit {

  @Input() mission: Mission;
  applications: Application[];
  applicationStatuses: ApplicationStatus[];

  waitingApplications: Application[] = [];
  acceptedApplications: Application[] = [];
  refusedApplications: Application[] = [];

  waitingStatus: ApplicationStatus;
  acceptedStatus: ApplicationStatus;
  refusedStatus: ApplicationStatus;

  constructor(private applicationService: ApplicationService) { }

  ngOnInit() {
    this.getApplicationStatuses();
    this.getMissionApplications(this.mission);
  }

  getMissionApplications(mission: Mission) {
    return this.applicationService.getMissionApplications(mission)
      .subscribe(applications => {
        this.applications = applications;
        applications
          .map(application => {
            switch (application.status) {
              case 'waiting':
                this.waitingApplications.push(application);
                break;
              case 'accepted':
                this.acceptedApplications.push(application);
                break;
              case 'refused':
                this.refusedApplications.push(application);
                break;
              default: break;
            }
          })
      });
  }

  getApplicationStatuses() {
    this.applicationService.getApplicationStatuses().subscribe(statuses => {
      this.applicationStatuses = statuses;
      statuses.map(status => {
        switch (status.status) {
          case 'waiting':
            this.waitingStatus = status;
            break;
          case 'accepted':
            this.acceptedStatus = status;
            break;
          case 'refused':
            this.refusedStatus = status;
            break;
        }
      });
    });
  }

}
