import { NgModule } from '@angular/core';
import { RouterModule, Routes } from "@angular/router";
import { StatisticComponent } from "./statistic/statistic.component";
import { AuthGuard } from "../../core/guards/auth.guard";

const staffRoutes: Routes = [
  {
    path: 'statistics',
    component: StatisticComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Statistiques',
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
