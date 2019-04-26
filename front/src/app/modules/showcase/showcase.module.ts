import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from "@angular/router";
import { SuiModule } from "ng2-semantic-ui";
import { ReactiveFormsModule } from "@angular/forms";
import { HomeComponent } from "./home/home.component";
import { ContactUsModalComponent } from "./modals/contact-us-modal/contact-us-modal.component";
import { LoginModalComponent } from "./modals/login-modal/login-modal.component";
import { SharedModule } from "../../shared/shared.module";

@NgModule({
  imports: [
    RouterModule,
    CommonModule,
    SuiModule,
    ReactiveFormsModule,
    SharedModule,
  ],
  declarations: [
    HomeComponent,
    LoginModalComponent,
    ContactUsModalComponent,
  ],
  entryComponents: [
    LoginModalComponent,
    ContactUsModalComponent,
  ]
})
export class ShowcaseModule { }
