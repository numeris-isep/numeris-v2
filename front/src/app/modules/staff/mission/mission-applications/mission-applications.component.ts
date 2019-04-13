import { Component, Input, OnInit } from '@angular/core';
import { Mission } from "../../../../core/classes/models/mission";
import { Application } from "../../../../core/classes/models/application";
import { ApplicationService } from "../../../../core/http/application.service";

@Component({
  selector: 'app-mission-applications',
  templateUrl: './mission-applications.component.html'
})
export class MissionApplicationsComponent implements OnInit {

  @Input() mission: Mission;
  applications: Application[];
  waitingApplications: Application[] = [];
  acceptedApplications: Application[] = [];
  refusedApplications: Application[] = [];

  constructor(private applicationService: ApplicationService) { }

  ngOnInit() {
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

}
