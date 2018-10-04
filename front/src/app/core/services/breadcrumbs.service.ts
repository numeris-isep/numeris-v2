import { Injectable } from '@angular/core';
import { Breadcrumb } from "../classes/breadcrumb";
import { BehaviorSubject } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class BreadcrumbsService {

  private breadcrumbs: BehaviorSubject<Breadcrumb> = new BehaviorSubject<Breadcrumb>(null);

  constructor() { }

  addBreadcrumb(breadcrumb: Breadcrumb) {
    this.breadcrumbs.next(breadcrumb)
  }

  getBreadcrumbs(): BehaviorSubject<Breadcrumb> {
    return this.breadcrumbs;
  }
}
