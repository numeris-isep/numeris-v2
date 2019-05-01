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
import { UserModule } from "../user/user.module";
import { ProjectCreateComponent } from './project-create/project-create.component';
import { ProjectFormComponent } from './project-form/project-form.component';

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
    UserModule,
  ],
  declarations: [
    ProjectComponent,
    ProjectListComponent,
    ProjectIndexComponent,
    ProjectShowComponent,
    ProjectDetailsComponent,
    ProjectCreateComponent,
    ProjectFormComponent
  ],
  exports: [ProjectListComponent]
})
export class ProjectModule { }
