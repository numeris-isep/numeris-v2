import { NgModule, OnInit } from "@angular/core";
import { CommonModule } from "@angular/common";
import { ActivatedRoute, NavigationEnd, Router, RouterModule, Routes } from "@angular/router";
import { NotFoundComponent } from "./components/not-found/not-found.component";
import { HomeComponent } from "../modules/showcase/home/home.component";
import { filter, map } from "rxjs/operators";
import { TitleService } from "./services/title.service";

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

  baseTitle = 'Numéris ISEP';
  separator = ' - ';

  constructor(
    private activatedRoute: ActivatedRoute,
    private router: Router,
    private titleService: TitleService
  ) {
    this.router.events.pipe(
      filter(event => event instanceof NavigationEnd),
      map(() => {
        let child = this.activatedRoute.firstChild;
        while (child) {
          if (child.firstChild) {
            child = child.firstChild;
          } else if (child.snapshot.data && child.snapshot.data['title']) {
            return child.snapshot.data['title'];
          } else {
            return null;
          }
        }
        return null;
      })).subscribe( (title: any) => {
        let finalTitle = this.baseTitle;

        if (title != null) {
          finalTitle += this.separator + title;
        }

        this.titleService.setHeaderTitle(title); // Set header title
        this.titleService.setTabTitle(finalTitle); // Set browser tab title
    });
  }
}
