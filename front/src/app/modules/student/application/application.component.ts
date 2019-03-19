import { Component, OnInit } from '@angular/core';
import { Mission } from "../../../core/classes/models/mission";
import { Application } from "../../../core/classes/models/application";
import { ApplicationService } from "../../../core/http/application.service";
import * as moment from 'moment';
import { AuthService } from "../../../core/http/auth/auth.service";

@Component({
  selector: 'app-application',
  templateUrl: './application.component.html'
})
export class ApplicationComponent implements OnInit {

  applications: Application[];
  counter: number = 0;

  sortedMissionGroups = [
    { name: "Candidatures acceptées", color: "green", missions: <Mission[]>[] },
    { name: "Candidatures en cours", color: "blue", missions: <Mission[]>[] },
    { name: "Candidatures refusées", color: "red", missions: <Mission[]>[] },
    { name: "Historique", color: "grey", missions: <Mission[]>[] }
  ];

  constructor(
    private applicationService: ApplicationService,
    private authService: AuthService
  ) { }

  ngOnInit() {
    this.getMissions();
    console.log(this.sortedMissionGroups);
  }

  /**
   * Get and sort missions to make an user friendly display
   */
  getMissions() {
    let user_id: number = this.authService.getCurrentUserId();

    this.applicationService.getUserApplications(user_id).subscribe(
      applications => {
        this.applications = applications;
        applications
          .map(application => {
            this.counter++;
            let mission = application.mission;

            if (moment(mission.startAt).isBefore(moment())) {
              this.sortedMissionGroups[3].missions.push(mission);
            } else {
              switch (application.status) {
                case 'accepted':
                  this.sortedMissionGroups[0].missions.push(mission);
                  break;
                case 'waiting':
                  this.sortedMissionGroups[1].missions.push(mission);
                  break;
                case 'refused':
                  this.sortedMissionGroups[2].missions.push(mission);
                  break;
                default:
                  console.log('error');
                  break;
              }
            }
          })
      }
    )
  }

}
