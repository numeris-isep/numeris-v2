import { Component, OnInit } from '@angular/core';
import { Breadcrumb } from "../../classes/breadcrumb";
import { BreadcrumbsService } from "../../services/breadcrumbs.service";

@Component({
  selector: 'app-breadcrumb',
  templateUrl: './breadcrumbs.component.html'
})
export class BreadcrumbsComponent implements OnInit {

  breadcrumbs: Breadcrumb[];

  constructor(private breadcrumbsService: BreadcrumbsService) { }

  ngOnInit() {
    this.breadcrumbsService.getBreadcrumbs().subscribe((breadcrumb) => {
      this.breadcrumbs = breadcrumb;
    })
  }

}
