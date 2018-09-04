import { LOCALE_ID, NgModule } from "@angular/core";
import { AppComponent } from "./app.component";
import { BrowserModule } from "@angular/platform-browser";
import { ReactiveFormsModule } from "@angular/forms";
import { HTTP_INTERCEPTORS, HttpClientModule } from "@angular/common/http";
import { AppRoutingModule } from "./app-routing.module";
import { AlertComponent } from "./_directives/alert.component";
import { LoginComponent } from "./login/login.component";
import { ProfileComponent } from './profile/profile.component';
import { ErrorInterceptor } from "./_helpers/error-interceptor.service";
import { JwtInterceptor } from "./_helpers/jwt-interceptor.service";
import localeFr from "@angular/common/locales/fr";
import { registerLocaleData } from "@angular/common";
import { SuiModule } from 'ng2-semantic-ui';
import { SidebarComponent } from "./partials/sidebar/sidebar.component";
import { MenuComponent } from "./partials/menu/menu.component";
import { AccordionComponent } from './partials/sidebar/accordion/accordion.component';

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
    AccordionComponent
  ],
  providers: [
    { provide: LOCALE_ID, useValue: 'fr' },
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
