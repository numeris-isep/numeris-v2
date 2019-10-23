import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { StatisticComponent } from './statistic/statistic.component';
import { SuiModule } from 'ng2-semantic-ui';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { StaffRoutingModule } from './staff-routing.module';
import { SharedModule } from '../../shared/shared.module';
import { HttpClientModule } from '@angular/common/http';
import { ClientModule } from './client/client.module';
import { ProjectModule } from './project/project.module';
import { MissionModule } from './mission/mission.module';
import { UserModule } from './user/user.module';
import { AccountingModule } from './accounting/accounting.module';
import { OverallStatisticComponent } from './statistic/overall-statistic/overall-statistic.component';
import { DaresStatisticComponent } from './statistic/dares-statistic/dares-statistic.component';
import { CountStatisticComponent } from './statistic/count-statistic/count-statistic.component';
import { RoleCountChartComponent } from './statistic/role-count-chart/role-count-chart.component';

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
    AccountingModule,
  ],
  declarations: [
    StatisticComponent,
    OverallStatisticComponent,
    DaresStatisticComponent,
    CountStatisticComponent,
    RoleCountChartComponent,
  ]
})
export class StaffModule { }
