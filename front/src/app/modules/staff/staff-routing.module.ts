import { NgModule } from '@angular/core';
import { RouterModule, Routes } from "@angular/router";
import { StatisticComponent } from "./statistic/statistic.component";
import { AuthGuard } from "../../core/guards/auth.guard";
import { UserComponent } from "./user/user.component";
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
];

@NgModule({
  imports: [
    RouterModule.forChild(staffRoutes)
  ],
  exports: [RouterModule]
})
export class StaffRoutingModule { }
