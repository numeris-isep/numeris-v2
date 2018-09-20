import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { RouterModule, Routes } from "@angular/router";
import { HomeComponent } from "./showcase/home/home.component";
import { NotFoundComponent } from "./shared/not-found/not-found.component";

const appRoutes: Routes = [
  { path: '', component: HomeComponent },

  // otherwise redirect to home
  { path: '**', component: NotFoundComponent }
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
