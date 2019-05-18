import { Component, OnDestroy, OnInit } from '@angular/core';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { ActivatedRoute } from '@angular/router';
import { MissionService } from '../../../../core/http/mission.service';
import { Mission } from '../../../../core/classes/models/mission';
import * as moment from 'moment';
import { now } from 'moment';
import { AlertService } from '../../../../core/services/alert.service';
import { ApplicationHandlerService } from '../../../../core/services/handlers/application-handler.service';
import { Application } from 'src/app/core/classes/models/application';

@Component({
  selector: 'app-mission-show',
  templateUrl: './mission-show.component.html'
})
export class MissionShowComponent implements OnInit, OnDestroy {

  mission: Mission;
  applications: Application[];

  constructor(
    private route: ActivatedRoute,
    private missionService: MissionService,
    private applicationHandler: ApplicationHandlerService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getMission(parseInt(param.missionId));
    });
    this.getApplications();
  }

  ngOnDestroy() {
    this.applicationHandler.resetAll();
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

  getApplications() {
    this.applicationHandler.getApplications().subscribe(applications => this.applications = applications);
  }

  isMissionExpired(mission: Mission) {
    return moment(mission.startAt).isBefore(now());
  }

  updateLock() {
    this.missionService.updateMissionLock(!this.mission.isLocked, this.mission).subscribe(
      () => this.mission.isLocked = !this.mission.isLocked,
      errors => this.alertService.error(errors.isLocked || errors)
    );
  }

}
