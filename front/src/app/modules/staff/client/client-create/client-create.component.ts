import { Component, OnInit, ViewChild } from '@angular/core';
import { ClientFormComponent } from '../client-form/client-form.component';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { handleFormDeactivation } from '../../../../core/functions/form-deactivate-handler';

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
    return handleFormDeactivation(this.clientFormComponent, 'clientForm');
  }

}
