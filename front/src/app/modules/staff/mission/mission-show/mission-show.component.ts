import { Component, OnInit } from '@angular/core';
import { TitleService } from "../../../../core/services/title.service";
import { BreadcrumbsService } from "../../../../core/services/breadcrumbs.service";
import { ActivatedRoute } from "@angular/router";
import { MissionService } from "../../../../core/http/mission.service";
import { Mission } from "../../../../core/classes/models/mission";
import * as moment from "moment";
import { now } from "moment";
import { AlertService } from "../../../../core/services/alert.service";

@Component({
  selector: 'app-mission-show',
  templateUrl: './mission-show.component.html',
  styleUrls: ['./mission-show.component.css']
})
export class MissionShowComponent implements OnInit {

  mission: Mission;

  constructor(
    private route: ActivatedRoute,
    private missionService: MissionService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getMission(parseInt(param.id));
    })
  }

  getMission(missionId: number) {
    this.missionService.getMission(missionId).subscribe(mission => {
      this.mission = mission;

      this.titleService.setTitles(mission.title);
      this.breadcrumbsService.setBreadcrumb(
        this.route.snapshot,
        { title: mission.title, url: '' }
      );
    });
  }

  isMissionExpired(mission: Mission) {
    return moment(mission.startAt).isBefore(now());
  }

  updateLock() {
    this.missionService.updateMissionLock(!this.mission.isLocked, this.mission).subscribe(
      () => {
        this.mission.isLocked = !this.mission.isLocked;
        this.alertService.success([`Mission marquée comme ${this.mission.isLocked ? 'fermée' : 'ouverte'} aux candidatures.`]);
      },
      errors => this.alertService.error(errors.isLocked || errors)
    );
  }

}
