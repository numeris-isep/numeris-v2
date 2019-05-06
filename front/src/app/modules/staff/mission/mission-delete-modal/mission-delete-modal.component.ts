import { Component, OnInit } from '@angular/core';
import { Mission } from "../../../../core/classes/models/mission";
import { ComponentModalConfig, ModalSize, SuiModal } from "ng2-semantic-ui";
import { MissionService } from "../../../../core/http/mission.service";
import { AlertService } from "../../../../core/services/alert.service";
import { Router } from "@angular/router";
import { Observable } from "rxjs";

export interface IMissionDeleteModalContext {
  title: string;
  question: string;
  mission: Mission;
}

@Component({
  selector: 'app-mission-delete-modal',
  templateUrl: './mission-delete-modal.component.html'
})
export class MissionDeleteModalComponent implements OnInit {

  mission: Mission = this.modal.context.mission;

  loading: boolean = false;

  constructor(
    public modal: SuiModal<IMissionDeleteModalContext, void>,
    private missionService: MissionService,
    private alertService: AlertService,
    private router: Router
  ) { }

  ngOnInit() {
  }

  onClick() {
    this.loading = true;

    this.deleteMission().subscribe(
      () => {
        this.router.navigate(['/missions']);
        this.alertService.success([`La mission ${this.mission.title} a bien été supprimée.`]);
        this.modal.approve(undefined);
      },
      errors => this.modal.deny(undefined)
    )
  }

  deleteMission(): Observable<Mission> {
    return this.missionService.deleteMission(this.mission);
  }

}

export class MissionDeleteModal extends ComponentModalConfig<IMissionDeleteModalContext, void> {

  constructor(
    title: string,
    question: string,
    mission: Mission,
    size = ModalSize.Small,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(MissionDeleteModalComponent, { title, question, mission });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }

}
