import { Component, Input, OnInit } from '@angular/core';
import { Mission } from '../../../../core/classes/models/mission';
import { ApplicationStatus } from '../../../../core/classes/models/application';
import { ApplicationHandlerService } from '../../../../core/services/handlers/application-handler.service';
import { ApplicationService } from '../../../../core/http/application.service';

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
    private applicationHandler: ApplicationHandlerService,
  ) { }

  ngOnInit() {
    this.getApplicationStatuses();
    this.watchMissionApplications(this.mission);
  }

  watchMissionApplications(mission: Mission) {
    this.applicationHandler.watchApplications(mission);
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
