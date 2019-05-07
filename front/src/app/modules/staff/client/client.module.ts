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
import { ClientDeleteModalComponent } from './client-delete-modal/client-delete-modal.component';
import { ClientProjectCreateComponent } from './client-project-create/client-project-create.component';
import { ContactListComponent } from './contact-list/contact-list.component';
import { ContactCreateComponent } from './contact-create/contact-create.component';
import { ContactFormComponent } from './contact-form/contact-form.component';

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
    ClientDeleteModalComponent,
    ClientProjectCreateComponent,
    ContactListComponent,
    ContactCreateComponent,
    ContactFormComponent,
  ],
  entryComponents: [
    ClientDeleteModalComponent,
  ]
})
export class ClientModule { }
