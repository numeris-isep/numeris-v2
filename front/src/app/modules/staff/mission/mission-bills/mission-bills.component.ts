import { Component, Input, OnInit, ViewChild } from '@angular/core';
import { Mission } from '../../../../core/classes/models/mission';
import { Application } from '../../../../core/classes/models/application';
import { BillsFormComponent } from './bills-form/bills-form.component';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { equals } from '../../../../shared/utils';

@Component({
  selector: 'app-mission-bills',
  templateUrl: './mission-bills.component.html'
})
export class MissionBillsComponent implements OnInit, CanComponentDeactivate {

  @ViewChild(BillsFormComponent) billsFormComponent: BillsFormComponent;

  @Input() mission: Mission;
  @Input() applications: Application[];

  constructor() { }

  ngOnInit() {
  }

  canDeactivate() {
    try {
      return equals(
        this.billsFormComponent.initialValue,
        this.billsFormComponent.billsForm.value
      );
    } catch (e) {
      return true;
    }
  }

}
