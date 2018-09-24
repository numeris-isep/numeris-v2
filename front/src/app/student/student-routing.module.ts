import { NgModule } from '@angular/core';
import { RouterModule, Routes } from "@angular/router";
import { DashboardComponent } from "./dashboard/dashboard.component";
import { AuthGuard } from "../auth/auth-guard.service";
import { ProfileComponent } from "./profile/profile.component";
import { TermsOfUseComponent } from "./terms-of-use/terms-of-use.component";

const studentRoutes: Routes = [
  { path: 'dashboard', component: DashboardComponent, canActivate: [AuthGuard] },
  { path: 'profile', component: ProfileComponent, canActivate: [AuthGuard] },
  { path: 'terms-of-use', component: TermsOfUseComponent, canActivate: [AuthGuard] }
];

@NgModule({
  imports: [
    RouterModule.forChild(studentRoutes)
  ],
  exports: [RouterModule]
})
export class StudentRoutingModule { }
