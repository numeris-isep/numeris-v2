import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { ActivatedRoute, NavigationEnd, Router, RouterModule, Routes, UrlSegment } from "@angular/router";
import { NotFoundComponent } from "./components/not-found/not-found.component";
import { HomeComponent } from "../modules/showcase/home/home.component";
import { distinctUntilChanged, filter, map } from "rxjs/operators";
import { TitleService } from "./services/title.service";
import { BreadcrumbsService } from "./services/breadcrumbs.service";

const appRoutes: Routes = [
  {
    path: '',
    component: HomeComponent
  },

  // otherwise 404
  {
    path: '**',
    component: NotFoundComponent,
    data: {
      title: 'Page inconnue'
    }
  }
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forRoot(appRoutes)
  ],
  exports: [
    RouterModule
  ]
})
export class AppRoutingModule {

  baseTitle: string = 'Numéris ISEP';
  separator: string = ' - ';

  constructor(
    private activatedRoute: ActivatedRoute,
    private router: Router,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService
  ) {
    this.router.events.pipe(
      filter(event => event instanceof NavigationEnd),
      distinctUntilChanged(),
      map(() => {
        let child = this.activatedRoute.firstChild;
        while (child) {
          if (child.firstChild) {
            child = child.firstChild;
          } else if (child.snapshot) {
            return child.snapshot;
          } else {
            return null;
          }
        }
        return null;
      })).subscribe( (child: any) => {
        if (child.data['title']) {
          let finalTitle = this.baseTitle;

          const title: string = child.data['title'];

          if (title != null) {
            finalTitle += this.separator + title;
          }

          this.titleService.setHeaderTitle(title); // Set header title
          this.titleService.setTabTitle(finalTitle); // Set browser tab title

          if (child.url) {
            // TODO: manage child routes
            let url: UrlSegment = child.url[0];

            this.breadcrumbsService.addBreadcrumb({title: title, url: url.path})
          }
        }
    });
  }
}
