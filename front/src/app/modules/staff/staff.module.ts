import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MissionComponent } from './mission/mission.component';
import { StatisticComponent } from './statistic/statistic.component';
import { UserComponent } from './user/user.component';
import { SuiModule } from "ng2-semantic-ui";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { StaffRoutingModule } from "./staff-routing.module";
import { SharedModule } from "../../shared/shared.module";
import { HttpClientModule } from "@angular/common/http";
import { ClientModule } from "./client/client.module";
import { ProjectModule } from "./project/project.module";

@NgModule({
  imports: [
    CommonModule,
    SuiModule,
    FormsModule,
    ReactiveFormsModule,
    SharedModule,
    HttpClientModule,
    StaffRoutingModule,

    // MUST be the last imports
    ClientModule,
    ProjectModule,
  ],
  declarations: [
    MissionComponent,
    StatisticComponent,
    UserComponent,
  ]
})
export class StaffModule { }
