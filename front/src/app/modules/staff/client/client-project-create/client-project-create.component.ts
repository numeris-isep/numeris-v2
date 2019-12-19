import { Component, OnInit, ViewChild } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ClientService } from '../../../../core/http/client.service';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { Client } from '../../../../core/classes/models/client';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { ProjectFormComponent } from '../../project/project-form/project-form.component';
import { handleFormDeactivation } from '../../../../core/functions/form-deactivate-handler';

@Component({
  selector: 'app-client-project-create',
  templateUrl: './client-project-create.component.html'
})
export class ClientProjectCreateComponent implements OnInit, CanComponentDeactivate {

  @ViewChild(ProjectFormComponent) projectFormComponent: ProjectFormComponent;

  client: Client;

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
    return handleFormDeactivation(this.projectFormComponent, 'projectForm');
  }

  getClient(clientId: number) {
    return this.clientService.getClient(clientId).subscribe(
      client => {
        this.client = client;

        this.titleService.setTitles(`${client.name} - Nouveau projet`);
        this.breadcrumbsService.setBreadcrumb(
          this.route.snapshot,
          [{ title: client.name, url: `/clients/${client.id}` }, { title: 'Nouveau projet', url: '' }]
        );
      },
      errors => {},
    );
  }

}
