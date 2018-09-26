import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { StudentRoutingModule } from "./student-routing.module";
import { DashboardComponent } from "./dashboard/dashboard.component";
import { ProfileComponent } from "./profile/profile.component";
import { TermsOfUseComponent } from "./terms-of-use/terms-of-use.component";
import { SuiModule } from "ng2-semantic-ui";

@NgModule({
  imports: [
    CommonModule,
    SuiModule,
    StudentRoutingModule
  ],
  declarations: [
    DashboardComponent,
    ProfileComponent,
    TermsOfUseComponent
  ]
})
export class StudentModule { }
