import { LOCALE_ID, NgModule } from "@angular/core";
import { AppComponent } from "./app.component";
import { BrowserModule, Title } from "@angular/platform-browser";
import { ReactiveFormsModule } from "@angular/forms";
import { HttpClientModule } from "@angular/common/http";
import { AppRoutingModule } from "./app-routing.module";
import { AlertComponent } from "./common/alert/alert.component";
import { LoginComponent } from "./auth/login/login.component";
import { ProfileComponent } from './student/profile/profile.component';
import localeFr from "@angular/common/locales/fr";
import { registerLocaleData } from "@angular/common";
import { SuiModule } from 'ng2-semantic-ui';
import { SidebarComponent } from "./common/sidebar/sidebar.component";
import { MenuComponent } from "./common/menu/menu.component";
import { AccordionComponent } from './common/accordion/accordion.component';
import { HomeComponent } from './showcase/home/home.component';
import { DashboardComponent } from './student/dashboard/dashboard.component';
import { ConfirmModalComponent } from './common/modals/confirm-modal/confirm-modal.component';
import { LoginModalComponent } from "./common/modals/login-modal/login-modal.component";

// Setting to locale to 'fr'
registerLocaleData(localeFr, 'fr');

@NgModule({
  imports: [
    BrowserModule,
    ReactiveFormsModule,
    HttpClientModule,
    AppRoutingModule,
    SuiModule
  ],
  declarations: [
    AppComponent,
    AlertComponent,
    LoginComponent,
    ProfileComponent,
    SidebarComponent,
    MenuComponent,
    AccordionComponent,
    HomeComponent,
    DashboardComponent,
    ConfirmModalComponent,
    LoginModalComponent
  ],
  providers: [
    Title,
    { provide: LOCALE_ID, useValue: 'fr' },
  ],
  bootstrap: [AppComponent],
  entryComponents: [
    ConfirmModalComponent,
    LoginModalComponent
  ],
})
export class AppModule { }
