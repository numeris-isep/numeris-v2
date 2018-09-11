import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { RouterModule, Routes } from "@angular/router";
import { AuthGuard } from "./auth/auth-guard.service";
import { ProfileComponent } from "./student/profile/profile.component";
import { HomeComponent } from "./showcase/home/home.component";
import { DashboardComponent } from "./student/dashboard/dashboard.component";

const appRoutes: Routes = [
  { path: 'dashboard', component: DashboardComponent, canActivate: [AuthGuard] },
  { path: 'profile', component: ProfileComponent, canActivate: [AuthGuard] },

  { path: '', component: HomeComponent },

  // otherwise redirect to home
  { path: '**', redirectTo: '' }
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
