import { NgModule } from '@angular/core';
import { CommonModule  } from '@angular/common';
import { AlertComponent } from "./components/alert/alert.component";
import { FooterComponent } from "./components/footer/footer.component";
import { PodiumComponent } from "./components/podium/podium.component";
import { LoginModalComponent } from "./components/modals/login-modal/login-modal.component";
import { ContactUsModalComponent } from "./components/modals/contact-us-modal/contact-us-modal.component";
import { ConfirmModalComponent } from "./components/modals/confirm-modal/confirm-modal.component";
import { TeamComponent } from "./components/team/team.component";
import { SuiModule } from 'ng2-semantic-ui';
import { ReactiveFormsModule } from "@angular/forms";
import { ButtonContentComponent } from './components/button/button-content/button-content.component';
import { ButtonComponent } from './components/button/button/button.component';
import { LinkButtonComponent } from './components/button/link-button/link-button.component';
import { AlertService } from "../core/services/alert.service";

@NgModule({
  imports: [
    CommonModule,
    SuiModule,
    ReactiveFormsModule,
  ],
  declarations: [
    AlertComponent,
    FooterComponent,
    PodiumComponent,
    FooterComponent,
    TeamComponent,
    PodiumComponent,
    ConfirmModalComponent,
    ContactUsModalComponent,
    LoginModalComponent,
    ButtonContentComponent,
    ButtonComponent,
    LinkButtonComponent
  ],
  exports: [
    AlertComponent,
    FooterComponent,
    PodiumComponent,
    FooterComponent,
    TeamComponent,
    PodiumComponent,
    ConfirmModalComponent,
    ContactUsModalComponent,
    LoginModalComponent,
    ButtonContentComponent,
    ButtonComponent,
    LinkButtonComponent
  ],
  entryComponents: [
    ConfirmModalComponent,
    ContactUsModalComponent,
    LoginModalComponent,
  ],
  providers: [
    AlertService
  ]
})
export class SharedModule { }
