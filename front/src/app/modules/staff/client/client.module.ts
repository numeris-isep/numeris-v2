import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ClientComponent } from "./client.component";
import { ClientDetailsComponent } from "./client-details/client-details.component";
import { ClientShowComponent } from "./client-show/client-show.component";
import { ClientListComponent } from "./client-list/client-list.component";
import { ClientIndexComponent } from "./client-index/client-index.component";
import { HttpClientModule } from "@angular/common/http";
import { SuiModule } from "ng2-semantic-ui";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { SharedModule } from "../../../shared/shared.module";
import { ClientRoutingModule } from "./client-routing.module";
import { ProjectModule } from "../project/project.module";
import { ClientConventionComponent } from './client-convention/client-convention.component';
import { ClientCreateComponent } from './client-create/client-create.component';
import { ClientFormComponent } from './client-form/client-form.component';
import { ClientEditComponent } from './client-edit/client-edit.component';

@NgModule({
  imports: [
    CommonModule,
    SuiModule,
    FormsModule,
    ReactiveFormsModule,
    SharedModule,
    HttpClientModule,
    ProjectModule,
    ClientRoutingModule,
  ],
  declarations: [
    ClientComponent,
    ClientDetailsComponent,
    ClientShowComponent,
    ClientListComponent,
    ClientIndexComponent,
    ClientConventionComponent,
    ClientCreateComponent,
    ClientFormComponent,
    ClientEditComponent,
  ],
})
export class ClientModule { }
