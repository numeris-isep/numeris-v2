import { Component, OnInit } from '@angular/core';
import { Mission } from "../../../core/classes/models/mission";
import * as moment from 'moment';
import { AuthService } from "../../../core/http/auth/auth.service";
import { MissionService } from "../../../core/http/mission.service";

@Component({
  selector: 'app-application',
  templateUrl: './application.component.html'
})
export class ApplicationComponent implements OnInit {

  missions: Mission[];
  counter: number = 0;

  sortedMissionGroups = [
    { name: "Candidatures acceptées", color: "green", missions: <Mission[]>[] },
    { name: "Candidatures en cours", color: "blue", missions: <Mission[]>[] },
    { name: "Historique", color: "grey", missions: <Mission[]>[] }
  ];

  constructor(
    private missionService: MissionService,
    private authService: AuthService
  ) { }

  ngOnInit() {
    this.getMissions();
  }

  /**
   * Get and sort missions to make an user friendly display
   */
  getMissions() {
    this.missionService.getAvailableMissions().subscribe(
      missions => {
        this.missions = missions;
        missions
          .map(mission => {
            const currentUserId: number = this.authService.getCurrentUserId();
            this.counter++;
            mission.applications
              .filter((application) => {
                if (application.userId == currentUserId) {
                  if (moment(mission.startAt).isBefore(moment())) {
                    this.sortedMissionGroups[2].missions.push(mission);
                  } else {
                    switch (application.status) {
                      case 'accepted':
                        this.sortedMissionGroups[0].missions.push(mission);
                        break;
                      case 'waiting':
                        this.sortedMissionGroups[1].missions.push(mission);
                        break;
                      default: break;
                    }
                  }
                }
              });
          });
        // Remove groups with no mission
        this.sortedMissionGroups = this.sortedMissionGroups.filter(
          (group) => group.missions.length > 0 ? group : null
        );
      }
    )
  }

}
