import { Injectable } from '@angular/core';
import { Breadcrumb } from "../classes/breadcrumb";
import { BehaviorSubject } from "rxjs";
import { ActivatedRoute, ActivatedRouteSnapshot, UrlSegment } from "@angular/router";

@Injectable({
  providedIn: 'root'
})
export class BreadcrumbsService {

  private breadcrumbs: BehaviorSubject<Breadcrumb[]> = new BehaviorSubject<Breadcrumb[]>(null);

  constructor() { }

  addBreadcrumb(breadcrumb: Breadcrumb[]) {
    this.breadcrumbs.next(breadcrumb)
  }

  getBreadcrumbs(): BehaviorSubject<Breadcrumb[]> {
    return this.breadcrumbs;
  }

  setBreadcrumb(route: ActivatedRouteSnapshot, breadcrumb?: Breadcrumb) {
    if (route.url) {
      let title: string = route.data['title'];
      let url: UrlSegment = route.url[0];
      let breadcrumbs = [];

      if (title && url) {
        if (route.parent && route.parent.url[0]) {
          breadcrumbs.push({title: route.parent.data['title'], url: route.parent.url[0]});
        }

        breadcrumbs.push({title: title, url: url.path});
        this.addBreadcrumb(breadcrumbs);
      } else {
        breadcrumbs = [BreadcrumbsService.getAncestorBreadcrumbs(route)[0]];

        if (breadcrumb) {
          breadcrumbs.push(breadcrumb);
        }

        this.addBreadcrumb(breadcrumbs);
      }
    }

  }

  static getAncestorBreadcrumbs(route: ActivatedRouteSnapshot): Breadcrumb[] {
    let parent = route.parent;
    let breadcrumbs: Breadcrumb[] = [];

    while (parent) {
      if (parent.parent) {
        breadcrumbs.push({title: parent.data['title'] , url: parent.url[0].path});
        parent = parent.parent;
      } else {
        parent = null;
      }
    }

    return breadcrumbs;
  }

  static getChildrenBreadcrumbs(route: ActivatedRouteSnapshot): Breadcrumb[] {
    let child = route.firstChild;
    let breadcrumbs: Breadcrumb[] = [];

    while (child) {
      if (child.firstChild) {
        breadcrumbs.push({title: child.data['title'] , url: child.url[0].path});
        child = child.firstChild;
      } else {
        child = null;
      }
    }

    return breadcrumbs;
  }
}
