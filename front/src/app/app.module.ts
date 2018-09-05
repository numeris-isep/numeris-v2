import { LOCALE_ID, NgModule } from "@angular/core";
import { AppComponent } from "./app.component";
import { BrowserModule, Title } from "@angular/platform-browser";
import { ReactiveFormsModule } from "@angular/forms";
import { HTTP_INTERCEPTORS, HttpClientModule } from "@angular/common/http";
import { AppRoutingModule } from "./app-routing.module";
import { AlertComponent } from "./directives/alert.component";
import { LoginComponent } from "./components/login/login.component";
import { ProfileComponent } from './components/profile/profile.component';
import { ErrorInterceptor } from "./helpers/error-interceptor.service";
import { JwtInterceptor } from "./helpers/jwt-interceptor.service";
import localeFr from "@angular/common/locales/fr";
import { registerLocaleData } from "@angular/common";
import { SuiModule } from 'ng2-semantic-ui';
import { SidebarComponent } from "./components/partials/sidebar/sidebar.component";
import { MenuComponent } from "./components/partials/sidebar/menu/menu.component";
import { AccordionComponent } from './components/partials/sidebar/accordion/accordion.component';
import { HomeComponent } from './components/home/home.component';
import { DashboardComponent } from './components/dashboard/dashboard.component';

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
    DashboardComponent
  ],
  providers: [
    Title,
    { provide: LOCALE_ID, useValue: 'fr' },
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
