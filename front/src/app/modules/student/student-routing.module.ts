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
import { ActivatedGuard } from "../../core/guards/activated.guard";

const studentRoutes: Routes = [
  {
    path: 'tableau-de-bord',
    component: DashboardComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Tableau de bord',
    }
  },
  {
    path: 'profil',
    component: ProfileComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Profil',
    }
  },
  {
    path: 'missions-disponibles',
    component: MissionComponent,
    canActivate: [AuthGuard, ActivatedGuard],
    data: {
      title: 'Missions disponibles',
    }
  },
  {
    path: 'candidatures',
    component: ApplicationComponent,
    canActivate: [AuthGuard, ActivatedGuard],
    data: {
      title: 'Candidatures',
    }
  },
  {
    path: 'tutoriels',
    component: TutorialComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Tutoriels',
    }
  },
  {
    path: 'nous-contacter',
    component: ContactUsComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Nous contacter',
    }
  },
  {
    path: 'conditions-dutilisation',
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
