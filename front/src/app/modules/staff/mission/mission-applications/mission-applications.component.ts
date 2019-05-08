import { Component, Input, OnInit } from '@angular/core';
import { Mission } from "../../../../core/classes/models/mission";
import { ApplicationStatus } from "../../../../core/classes/models/application";
import { ApplicationHandlerService } from "../../../../core/services/application-handler.service";
import { ApplicationService } from "../../../../core/http/application.service";

@Component({
  selector: 'app-mission-applications',
  templateUrl: './mission-applications.component.html'
})
export class MissionApplicationsComponent implements OnInit {

  @Input() mission: Mission;
  applicationStatuses: ApplicationStatus[];

  waitingStatus: ApplicationStatus;
  acceptedStatus: ApplicationStatus;
  refusedStatus: ApplicationStatus;

  constructor(
    private applicationService: ApplicationService,
    private applicationHandlerService: ApplicationHandlerService,
  ) { }

  ngOnInit() {
    this.getApplicationStatuses();
    this.setMissionApplications(this.mission);
  }

  setMissionApplications(mission: Mission) {
    this.applicationHandlerService.setApplications(mission);
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
