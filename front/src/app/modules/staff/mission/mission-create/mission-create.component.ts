import { Component, OnInit, ViewChild } from '@angular/core';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { MissionFormComponent } from '../mission-form/mission-form.component';
import { handleFormDeactivation } from '../../../../core/functions/form-deactivate-handler';

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
    return handleFormDeactivation(this.missionFormComponent, 'missionForm');
  }

}
