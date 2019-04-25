import { Component, OnInit } from '@angular/core';
import { BreadcrumbsService } from "../../../../core/services/breadcrumbs.service";
import { ActivatedRoute } from "@angular/router";

@Component({
  selector: 'app-client-create',
  templateUrl: './client-create.component.html'
})
export class ClientCreateComponent implements OnInit {

  constructor(
    private route: ActivatedRoute,
    private breadcrumbsService: BreadcrumbsService
  ) { }

  ngOnInit() {
    this.breadcrumbsService.setBreadcrumb(
      this.route.snapshot,
      { title: 'Nouveau client', url: '' }
    );
  }

}
