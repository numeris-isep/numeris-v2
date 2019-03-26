import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MissionComponent } from './mission/mission.component';
import { StatisticComponent } from './statistic/statistic.component';
import { UserComponent } from './user/user.component';
import { ProjectComponent } from './project/project.component';
import { ClientComponent } from './client/client.component';
import { SuiModule } from "ng2-semantic-ui";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { StaffRoutingModule } from "./staff-routing.module";
import { SharedModule } from "../../shared/shared.module";
import { HttpClientModule } from "@angular/common/http";
import { ClientDetailsComponent } from './client/client-details/client-details.component';

@NgModule({
  imports: [
    CommonModule,
    SuiModule,
    FormsModule,
    ReactiveFormsModule,
    StaffRoutingModule,
    SharedModule,
    HttpClientModule,
  ],
  declarations: [
    MissionComponent,
    StatisticComponent,
    UserComponent,
    ProjectComponent,
    ClientComponent,
    ClientDetailsComponent,
  ]
})
export class StaffModule { }
