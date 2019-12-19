import { Component, OnInit, ViewChild } from '@angular/core';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { equals } from '../../../../shared/utils';
import { MissionFormComponent } from '../mission-form/mission-form.component';

@Component({
  selector: 'app-mission-create',
  templateUrl: './mission-create.component.html'
})
export class MissionCreateComponent implements OnInit, CanComponentDeactivate {

  @ViewChild(MissionFormComponent) missionFormComponent: MissionFormComponent;

  constructor() { }

  ngOnInit() {
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

}
