import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ProjectComponent } from "./project.component";
import { SuiModule } from "ng2-semantic-ui";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { SharedModule } from "../../../shared/shared.module";
import { HttpClientModule } from "@angular/common/http";
import { ProjectRoutingModule } from "./project-routing.module";
import { ProjectListComponent } from './project-list/project-list.component';
import { ProjectIndexComponent } from './project-index/project-index.component';
import { ProjectShowComponent } from './project-show/project-show.component';
import { ProjectDetailsComponent } from './project-details/project-details.component';
import { MissionModule } from "../mission/mission.module";

@NgModule({
  imports: [
    CommonModule,
    SuiModule,
    FormsModule,
    ReactiveFormsModule,
    SharedModule,
    HttpClientModule,
    ProjectRoutingModule,
    MissionModule,
  ],
  declarations: [
    ProjectComponent,
    ProjectListComponent,
    ProjectIndexComponent,
    ProjectShowComponent,
    ProjectDetailsComponent
  ],
  exports: [ProjectListComponent]
})
export class ProjectModule { }
