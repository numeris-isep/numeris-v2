import { NgModule } from '@angular/core';
import { RouterModule, Routes } from "@angular/router";
import { StatisticComponent } from "./statistic/statistic.component";
import { AuthGuard } from "../../core/guards/auth.guard";
import { UserComponent } from "./user/user.component";
import { ProjectComponent } from "./project/project.component";
import { ClientComponent } from "./client/client.component";
import { MissionComponent } from "./mission/mission.component";

const staffRoutes: Routes = [
  {
    path: 'statistics',
    component: StatisticComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Statistiques',
    }
  },
  {
    path: 'users',
    component: UserComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Utilisateurs',
    }
  },
  {
    path: 'missions',
    component: MissionComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Missions',
    }
  },
  {
    path: 'projects',
    component: ProjectComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Projects',
    }
  },
  {
    path: 'clients',
    component: ClientComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Clients',
    }
  },
];

@NgModule({
  imports: [
    RouterModule.forChild(staffRoutes)
  ],
  exports: [RouterModule]
})
export class StaffRoutingModule { }
