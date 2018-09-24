import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DashboardComponent } from "./dashboard/dashboard.component";
import { ProfileComponent } from "./profile/profile.component";
import { StudentRoutingModule } from "./student-routing.module";
import { TermsOfUseComponent } from './terms-of-use/terms-of-use.component';
import { SuiModule } from 'ng2-semantic-ui';

@NgModule({
  imports: [
    CommonModule,
    StudentRoutingModule,
    SuiModule
  ],
  declarations: [
    DashboardComponent,
    ProfileComponent,
    TermsOfUseComponent,
  ]
})
export class StudentModule { }
