import { Component, OnInit, ViewChild } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ClientService } from '../../../../core/http/client.service';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { Client } from '../../../../core/classes/models/client';
import { ConventionFormComponent } from '../convention-form/convention-form.component';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { equals } from '../../../../shared/utils';

@Component({
  selector: 'app-convention-create',
  templateUrl: './convention-create.component.html'
})
export class ConventionCreateComponent implements OnInit, CanComponentDeactivate {

  client: Client;

  @ViewChild(ConventionFormComponent) conventionFormComponent: ConventionFormComponent;

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
    try {
      return equals(
        this.conventionFormComponent.initialValue,
        this.conventionFormComponent.conventionForm.value
      );
    } catch (e) {
      return true;
    }
  }

  getClient(clientId: number) {
    return this.clientService.getClient(clientId).subscribe(
      client => {
        this.client = client;

        this.titleService.setTitles(`${client.name} - Nouvelle convention`);
        this.breadcrumbsService.setBreadcrumb(
          this.route.snapshot,
          [{ title: client.name, url: `/clients/${client.id}` }, { title: 'Nouvelle convention', url: '' }]
        );
      },
      errors => {},
    );
  }

}
