import { NgModule } from '@angular/core';
import { RouterModule, Routes } from "@angular/router";
import { DashboardComponent } from "./dashboard/dashboard.component";
import { ProfileComponent } from "./profile/profile.component";
import { TermsOfUseComponent } from "./terms-of-use/terms-of-use.component";
import { AuthGuard } from "../../core/guards/auth.guard";
import { MissionComponent } from "./mission/mission.component";
import { ApplicationComponent } from "./application/application.component";
import { TutorialComponent } from "./tutorial/tutorial.component";
import { ContactUsComponent } from "./contact-us/contact-us.component";

const studentRoutes: Routes = [
  {
    path: 'dashboard',
    component: DashboardComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Tableau de bord',
    }
  },
  {
    path: 'profile',
    component: ProfileComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Profil',
    }
  },
  {
    path: 'missions',
    component: MissionComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Missions disponibles',
    }
  },
  {
    path: 'applications',
    component: ApplicationComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Candidatures',
    }
  },
  {
    path: 'tutorials',
    component: TutorialComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Tutoriels',
    }
  },
  {
    path: 'contact-us',
    component: ContactUsComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Nous contacter',
    }
  },
  {
    path: 'terms-of-use',
    component: TermsOfUseComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Conditions d\'utilisation'
    }
  }
];

@NgModule({
  imports: [
    RouterModule.forChild(studentRoutes)
  ],
  exports: [RouterModule]
})
export class StudentRoutingModule { }
