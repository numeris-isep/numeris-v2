import { NgModule } from '@angular/core';
import { CommonModule  } from '@angular/common';
import { AlertComponent } from "./components/alert/alert.component";
import { FooterComponent } from "./components/footer/footer.component";
import { PodiumComponent } from "./components/podium/podium.component";
import { LoginModalComponent } from "../modules/showcase/modals/login-modal/login-modal.component";
import { ContactUsModalComponent } from "../modules/showcase/modals/contact-us-modal/contact-us-modal.component";
import { ApplicationConfirmModalComponent } from "../modules/student/application/application-confirm-modal/application-confirm-modal.component";
import { TeamComponent } from "./components/team/team.component";
import { SuiModule } from 'ng2-semantic-ui';
import { ReactiveFormsModule } from "@angular/forms";
import { ButtonContentComponent } from './components/button/button-content/button-content.component';
import { ButtonComponent } from './components/button/button/button.component';
import { LinkButtonComponent } from './components/button/link-button/link-button.component';
import { AlertService } from "../core/services/alert.service";
import { LoaderComponent } from './components/loader/loader.component';
import { ContentComponent } from './components/content/content.component';
import { AddressPipe } from './pipes/address.pipe';
import { PhonePipe } from './pipes/phone.pipe';
import { EmptyComponent } from './components/empty/empty.component';
import { RolePipe } from './pipes/role.pipe';
import { RouterModule } from '@angular/router';
import { StatusPipe } from './pipes/status.pipe';
import { FormErrorComponent } from './components/form-error/form-error.component';

@NgModule({
  imports: [
    RouterModule,
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
    ButtonContentComponent,
    ButtonComponent,
    LinkButtonComponent,
    LoaderComponent,
    ContentComponent,
    AddressPipe,
    PhonePipe,
    EmptyComponent,
    RolePipe,
    StatusPipe,
    FormErrorComponent,
  ],
  exports: [
    // Components
    AlertComponent,
    FooterComponent,
    PodiumComponent,
    FooterComponent,
    TeamComponent,
    PodiumComponent,
    ButtonContentComponent,
    ButtonComponent,
    LinkButtonComponent,
    LoaderComponent,
    ContentComponent,
    EmptyComponent,
    FormErrorComponent,

    // Pipes
    AddressPipe,
    PhonePipe,
    RolePipe,
    StatusPipe,
  ],
  providers: [
    AlertService
  ]
})
export class SharedModule { }
