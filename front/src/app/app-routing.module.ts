import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { RouterModule, Routes } from "@angular/router";
import { HomeComponent } from "./showcase/home/home.component";

const appRoutes: Routes = [
  { path: '', component: HomeComponent },

  // otherwise redirect to home
  { path: '**', redirectTo: '', pathMatch: 'full' } // TODO: PageNotFoundComponent
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
export class AppRoutingModule { }
