import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { StatisticComponent } from './statistic/statistic.component';
import { SuiModule } from "ng2-semantic-ui";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { StaffRoutingModule } from "./staff-routing.module";
import { SharedModule } from "../../shared/shared.module";
import { HttpClientModule } from "@angular/common/http";
import { ClientModule } from "./client/client.module";
import { ProjectModule } from "./project/project.module";
import { MissionModule } from "./mission/mission.module";
import { UserModule } from "./user/user.module";

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
    MissionModule,
    UserModule,
  ],
  declarations: [
    StatisticComponent,
  ]
})
export class StaffModule { }
