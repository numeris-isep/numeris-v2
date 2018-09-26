import { LOCALE_ID, NgModule } from "@angular/core";
import { AppComponent } from "./app.component";
import { BrowserModule, Title } from "@angular/platform-browser";
import { ReactiveFormsModule } from "@angular/forms";
import { HTTP_INTERCEPTORS, HttpClientModule } from "@angular/common/http";
import { AppRoutingModule } from "./app-routing.module";
import localeFr from "@angular/common/locales/fr";
import { registerLocaleData } from "@angular/common";
import { BrowserAnimationsModule } from "@angular/platform-browser/animations";
import { SharedModule } from "../shared/shared.module";
import { ErrorInterceptorService } from "./interceptors/error-interceptor.service";
import { Router } from "@angular/router";
import { StudentModule } from "../modules/student/student.module";
import { SidebarComponent } from "./components/sidebar/sidebar.component";
import { MenuComponent } from "./components/menu/menu.component";
import { NotFoundComponent } from "./components/not-found/not-found.component";
import { HomeComponent } from "../modules/showcase/home/home.component";
import { SuiModule } from 'ng2-semantic-ui';

// Setting to locale to 'fr'
registerLocaleData(localeFr, 'fr');

@NgModule({
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    ReactiveFormsModule,
    HttpClientModule,
    SuiModule,

    // MUST be the last imports
    StudentModule,
    SharedModule,
    AppRoutingModule,
  ],
  declarations: [
    AppComponent,
    HomeComponent,
    SidebarComponent,
    MenuComponent,
    NotFoundComponent
  ],
  providers: [
    Title,
    { provide: LOCALE_ID, useValue: 'fr' },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptorService, multi: true },
  ],
  bootstrap: [AppComponent]
})
export class AppModule {
  // Uncomment these following lines to display the router configuration
  // (useful to see if the routes are in the proper order)

  constructor(router: Router) {
    console.log('Routes: ', JSON.stringify(router.config, undefined, 2));
  }
}
