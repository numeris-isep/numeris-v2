import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SuiModule } from "ng2-semantic-ui";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { SharedModule } from "../../../shared/shared.module";
import { HttpClientModule } from "@angular/common/http";
import { MissionRoutingModule } from "./mission-routing.module";
import { MissionIndexComponent } from './mission-index/mission-index.component';
import { MissionListComponent } from './mission-list/mission-list.component';
import { MissionComponent } from "./mission.component";

@NgModule({
  imports: [
    CommonModule,
    SuiModule,
    FormsModule,
    ReactiveFormsModule,
    SharedModule,
    HttpClientModule,
    MissionRoutingModule,
  ],
  declarations: [
    MissionComponent,
    MissionIndexComponent,
    MissionListComponent
  ],
  exports: [MissionListComponent]
})
export class MissionModule { }
