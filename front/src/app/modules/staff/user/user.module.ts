import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SuiModule } from "ng2-semantic-ui";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { SharedModule } from "../../../shared/shared.module";
import { HttpClientModule } from "@angular/common/http";
import { UserRoutingModule } from "./user-routing.module";
import { UserComponent } from "./user.component";
import { UserIndexComponent } from './user-index/user-index.component';
import { UserListComponent } from './user-list/user-list.component';

@NgModule({
  imports: [
    CommonModule,
    SuiModule,
    FormsModule,
    ReactiveFormsModule,
    SharedModule,
    HttpClientModule,
    UserRoutingModule,
  ],
  declarations: [
    UserComponent,
    UserIndexComponent,
    UserListComponent,
  ],
  exports: [
    UserListComponent
  ]
})
export class UserModule { }
