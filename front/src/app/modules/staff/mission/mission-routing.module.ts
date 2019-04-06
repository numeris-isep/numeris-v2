import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from "@angular/router";
import { MissionComponent } from "./mission.component";
import { AuthGuard } from "../../../core/guards/auth.guard";
import { MissionIndexComponent } from "./mission-index/mission-index.component";

const missionRoute: Routes = [
  {
    path: 'missions',
    component: MissionComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Missions',
    },
    children: [
      {
        path: '',
        component: MissionIndexComponent,
      },
      // {
      //   path: ':id',
      //   component: MissionShowComponent,
      // },
    ]
  },
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(missionRoute)
  ],
  exports: [RouterModule]
})
export class MissionRoutingModule { }
