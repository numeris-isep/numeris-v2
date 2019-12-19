import { Component, OnInit, ViewChild } from '@angular/core';
import { ClientFormComponent } from '../client-form/client-form.component';
import { equals } from '../../../../shared/utils';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';

@Component({
  selector: 'app-client-create',
  templateUrl: './client-create.component.html'
})
export class ClientCreateComponent implements OnInit, CanComponentDeactivate {

  @ViewChild(ClientFormComponent) private clientFormComponent: ClientFormComponent;

  constructor() { }

  ngOnInit() {
  }

  canDeactivate() {
    try {
      return equals(
        this.clientFormComponent.clientForm.value,
        this.clientFormComponent.initialValue
      );
    } catch (e) {
      return true;
    }
  }

}
