import { Component, OnInit } from '@angular/core';
import { TitleService } from "../../../../core/services/title.service";
import { BreadcrumbsService } from "../../../../core/services/breadcrumbs.service";
import { ActivatedRoute } from "@angular/router";
import { MissionService } from "../../../../core/http/mission.service";
import { Mission } from "../../../../core/classes/models/mission";

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
    private breadcrumbsService: BreadcrumbsService
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

}
