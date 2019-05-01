import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from "@angular/router";
import { BreadcrumbsService } from "../../../../core/services/breadcrumbs.service";

@Component({
  selector: 'app-project-create',
  templateUrl: './project-create.component.html'
})
export class ProjectCreateComponent implements OnInit {

  constructor(
    private route: ActivatedRoute,
    private breadcrumbsService: BreadcrumbsService
  ) { }

  ngOnInit() {
    this.breadcrumbsService.setBreadcrumb(
      this.route.snapshot,
      { title: 'Nouveau projet', url: '' }
    );
  }

}
