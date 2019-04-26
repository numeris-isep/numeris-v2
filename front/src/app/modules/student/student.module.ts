import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { StudentRoutingModule } from "./student-routing.module";
import { DashboardComponent } from "./dashboard/dashboard.component";
import { ProfileComponent } from "./profile/profile.component";
import { TermsOfUseComponent } from "./terms-of-use/terms-of-use.component";
import { SuiModule } from "ng2-semantic-ui";
import { ProfileDetailsComponent } from './profile/profile-details/profile-details.component';
import { ProfileSummaryComponent } from './profile/profile-summary/profile-summary.component';
import { SharedModule } from "../../shared/shared.module";
import { ProfilePreferencesComponent } from './profile/profile-preferences/profile-preferences.component';
import { ProfileDocumentsComponent } from './profile/profile-documents/profile-documents.component';
import { MissionComponent } from './mission/mission.component';
import { ApplicationComponent } from './application/application.component';
import { TutorialComponent } from './tutorial/tutorial.component';
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { HttpClientModule } from "@angular/common/http";
import { ContactUsComponent } from './contact-us/contact-us.component';
import { MissionDetailsComponent } from "./mission/mission-details/mission-details.component";
import { ApplicationConfirmModalComponent } from "./application/application-confirm-modal/application-confirm-modal.component";

@NgModule({
  imports: [
    CommonModule,
    SuiModule,
    FormsModule,
    ReactiveFormsModule,
    StudentRoutingModule,
    SharedModule,
    HttpClientModule,
  ],
  declarations: [
    DashboardComponent,
    ProfileComponent,
    TermsOfUseComponent,
    ProfileDetailsComponent,
    ProfileSummaryComponent,
    ProfilePreferencesComponent,
    ProfileDocumentsComponent,
    MissionComponent,
    ApplicationComponent,
    ApplicationConfirmModalComponent,
    TutorialComponent,
    ContactUsComponent,
    MissionDetailsComponent,
  ],
  exports: [
    ProfileDetailsComponent,
    ProfileSummaryComponent,
    ProfilePreferencesComponent,
    ProfileDocumentsComponent,
    MissionDetailsComponent,
  ],
  entryComponents: [
    ApplicationConfirmModalComponent,
  ]
})
export class StudentModule { }
