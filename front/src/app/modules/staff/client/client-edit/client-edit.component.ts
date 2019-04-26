import { Component, OnInit } from '@angular/core';
import { Client } from "../../../../core/classes/models/client";
import { ActivatedRoute } from "@angular/router";
import { ClientService } from "../../../../core/http/client.service";
import { TitleService } from "../../../../core/services/title.service";
import { BreadcrumbsService } from "../../../../core/services/breadcrumbs.service";

@Component({
  selector: 'app-client-edit',
  templateUrl: './client-edit.component.html'
})
export class ClientEditComponent implements OnInit {

  client: Client;

  constructor(
    private route: ActivatedRoute,
    private clientService: ClientService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getClient(parseInt(param.id));
    })
  }

  getClient(clientId: number) {
    return this.clientService.getClient(clientId).subscribe(client => {
      this.client = client;

      this.titleService.setTitles(`${client.name} - Modifier`);
      this.breadcrumbsService.setBreadcrumb(
        this.route.snapshot,
        { title: client.name, url: '' }
      );
    });
  }

}
