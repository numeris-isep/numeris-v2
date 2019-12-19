import { Component, OnInit, ViewChild } from '@angular/core';
import { Client } from '../../../../core/classes/models/client';
import { ActivatedRoute } from '@angular/router';
import { ClientService } from '../../../../core/http/client.service';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { ClientFormComponent } from '../client-form/client-form.component';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { equals } from '../../../../shared/utils';
import { handleFormDeactivation } from '../../../../core/functions/form-deactivate-handler';

@Component({
  selector: 'app-client-edit',
  templateUrl: './client-edit.component.html'
})
export class ClientEditComponent implements OnInit, CanComponentDeactivate {

  client: Client;

  @ViewChild(ClientFormComponent) private clientFormComponent: ClientFormComponent;

  constructor(
    private route: ActivatedRoute,
    private clientService: ClientService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService,
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getClient(parseInt(param.clientId));
    });
  }

  canDeactivate() {
    return handleFormDeactivation(this.clientFormComponent, 'clientForm');
  }

  getClient(clientId: number) {
    return this.clientService.getClient(clientId).subscribe(client => {
      this.client = client;

      this.titleService.setTitles(`${client.name} - Modifier`);
      this.breadcrumbsService.setBreadcrumb(
        this.route.snapshot,
        [{ title: client.name, url: `/clients/${client.id}` }, { title: 'Modifier', url: '' }]
      );
    });
  }

}
