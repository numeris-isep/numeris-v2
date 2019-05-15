import { Component, OnInit } from '@angular/core';
import { ClientService } from "../../../../core/http/client.service";
import { TitleService } from "../../../../core/services/title.service";
import { BreadcrumbsService } from "../../../../core/services/breadcrumbs.service";
import { Client } from "../../../../core/classes/models/client";
import { ActivatedRoute, Router } from "@angular/router";

@Component({
  selector: 'app-client-show',
  templateUrl: './client-show.component.html'
})
export class ClientShowComponent implements OnInit {

  client: Client;

  conventionTabActive: boolean = false;

  constructor(
    private route: ActivatedRoute,
    private clientService: ClientService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService,
    private router: Router
  ) { }

  ngOnInit() {
    this.route.data.subscribe(data => this.conventionTabActive = data['tab'] === 'conventions');

    this.route.params.subscribe(param => {
      this.getClient(parseInt(param.clientId));
    });
  }

  getClient(clientId: number) {
    return this.clientService.getClient(clientId).subscribe(
      client => {
        this.client = client;

        const breadcrumbs = [{ title: client.name, url: `/clients/${client.id}` }];
        if (this.conventionTabActive) { breadcrumbs.push({ title: 'Conventions', url: '' }); }

        this.titleService.setTitles(client.name);
        this.breadcrumbsService.setBreadcrumb(
          this.route.snapshot,
          breadcrumbs
        );
      },
        error => this.router.navigate(['erreur'])
    );
  }

}
