import { NgModule } from '@angular/core';
import { CommonModule as AngularCommonModule } from '@angular/common';
import { AlertComponent } from "./alert/alert.component";
import { FooterComponent } from "./footer/footer.component";
import { PodiumComponent } from "./podium/podium.component";
import { MenuComponent } from "./menu/menu.component";
import { SidebarComponent } from "./sidebar/sidebar.component";
import { AccordionComponent } from "./accordion/accordion.component";
import { LoginModalComponent } from "./modals/login-modal/login-modal.component";
import { ContactUsModalComponent } from "./modals/contact-us-modal/contact-us-modal.component";
import { ConfirmModalComponent } from "./modals/confirm-modal/confirm-modal.component";
import { TeamComponent } from "./team/team.component";
import { SuiModule } from 'ng2-semantic-ui';
import { AppRoutingModule } from "../app-routing.module";
import { ReactiveFormsModule } from "@angular/forms";

@NgModule({
  imports: [
    AngularCommonModule,
    SuiModule,
    AppRoutingModule,
    ReactiveFormsModule,
  ],
  declarations: [
    AlertComponent,
    FooterComponent,
    PodiumComponent,
    MenuComponent,
    SidebarComponent,
    AccordionComponent,
    FooterComponent,
    TeamComponent,
    PodiumComponent,
    ConfirmModalComponent,
    ContactUsModalComponent,
    LoginModalComponent,
  ],
  exports: [
    AlertComponent,
    FooterComponent,
    PodiumComponent,
    MenuComponent,
    SidebarComponent,
    AccordionComponent,
    FooterComponent,
    TeamComponent,
    PodiumComponent,
    ConfirmModalComponent,
    ContactUsModalComponent,
    LoginModalComponent,
  ],
  entryComponents: [
    ConfirmModalComponent,
    ContactUsModalComponent,
    LoginModalComponent,
  ],
})
export class SharedModule { }
