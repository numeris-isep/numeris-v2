import { Component, OnInit } from '@angular/core';
import { Mission } from '../../../../core/classes/models/mission';
import { MissionService } from '../../../../core/http/mission.service';

@Component({
  selector: 'app-mission-notify',
  templateUrl: './mission-notify.component.html'
})
export class MissionNotifyComponent implements OnInit {

  missions: Mission[];

  constructor(private missionService: MissionService) { }

  ngOnInit() {
    this.getAvailableMissions();
  }

  getAvailableMissions() {
    this.missionService.getAvailableMissions().subscribe(missions => (
      this.missions = missions.filter(mission => ! mission.project.isPrivate)
    ));
  }

}
