import { Component, OnInit } from '@angular/core';
import { Mission } from "../../../core/classes/models/mission";
import { MissionService } from "../../../core/http/mission.service";
import * as moment from 'moment';
import { Moment } from "moment";

@Component({
  selector: 'app-mission',
  templateUrl: './mission.component.html'
})
export class MissionComponent implements OnInit {

  missions: Mission[];
  counter: number = 0;

  thisWeek: Moment[] = [
    moment().startOf('isoWeek'),
    moment().endOf('isoWeek')
  ];
  nextWeek: Moment[] = [
    moment().add(1, 'week').startOf('isoWeek'),
    moment().add(1, 'week').endOf('isoWeek')
  ];
  inTwoWeeks: Moment[] = [
    moment().add(2, 'week').startOf('isoWeek'),
    moment().add(2, 'week').endOf('isoWeek')
  ];

  sortedMissionGroups = [
    { name: "Cette semaine", range: this.thisWeek, missions: <Mission[]>[] },
    { name: "La semaine prochaine", range: this.nextWeek, missions: <Mission[]>[] },
    { name: "Dans 2 semaines", range: this.inTwoWeeks, missions: <Mission[]>[] },
    { name: "Prochainement", range: [], missions: <Mission[]>[] },
  ];

  constructor(private missionService: MissionService) { }

  ngOnInit() {
    this.getMissions();
  }

  /**
   * Get and sort missions to make an user friendly display
   */
  getMissions() {
    this.missionService.getMissions().subscribe(
      missions => {
        this.missions = missions;
        missions
          .filter(mission => moment(mission.startAt).isAfter(moment()))
          .map(mission => {
            this.counter++;
            let missionDate = moment(mission.startAt);

            switch (true) {
              case missionDate.isBetween(this.sortedMissionGroups[0].range[0], this.sortedMissionGroups[0].range[1]):
                this.sortedMissionGroups[0].missions.push(mission);
                break;
              case missionDate.isBetween(this.sortedMissionGroups[1].range[0], this.sortedMissionGroups[1].range[1]):
                this.sortedMissionGroups[1].missions.push(mission);
                break;
              case missionDate.isBetween(this.sortedMissionGroups[2].range[0], this.sortedMissionGroups[2].range[1]):
                this.sortedMissionGroups[2].missions.push(mission);
                break;
              case missionDate.isAfter(this.sortedMissionGroups[2].range[1]):
                this.sortedMissionGroups[3].missions.push(mission);
                break;
              default: break;
            }
        })
    });
  }
}
