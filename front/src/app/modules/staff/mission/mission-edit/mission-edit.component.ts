import { Component, OnInit, ViewChild } from '@angular/core';
import { Mission } from '../../../../core/classes/models/mission';
import { ActivatedRoute } from '@angular/router';
import { MissionService } from '../../../../core/http/mission.service';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { MissionFormComponent } from '../mission-form/mission-form.component';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { equals } from '../../../../shared/utils';

@Component({
  selector: 'app-mission-edit',
  templateUrl: './mission-edit.component.html'
})
export class MissionEditComponent implements OnInit, CanComponentDeactivate {

  @ViewChild(MissionFormComponent) missionFormComponent: MissionFormComponent;

  mission: Mission;

  constructor(
    private route: ActivatedRoute,
    private missionService: MissionService,
    private titleService: TitleService,
    private breadcrumbService: BreadcrumbsService,
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getMission(parseInt(param.missionId));
    });
  }

  canDeactivate() {
    try {
      return equals(
        this.missionFormComponent.initialValue,
        this.missionFormComponent.missionForm.value
      );
    } catch (e) {
      return true;
    }
  }

  getMission(missionId: number) {
    return this.missionService.getMission(missionId).subscribe(mission => {
      this.mission = mission;

      this.titleService.setTitles(`${mission.title} - Modifier`);
      this.breadcrumbService.setBreadcrumb(
        this.route.snapshot,
        [{ title: mission.title, url: `/missions/${mission.id}` }, { title: 'Modifier', url: '' }]
      );
    });
  }

}
