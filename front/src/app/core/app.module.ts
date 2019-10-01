import { LOCALE_ID, NgModule } from '@angular/core';
import { AppComponent } from './app.component';
import { BrowserModule, Title } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HTTP_INTERCEPTORS, HttpClientModule } from '@angular/common/http';
import { AppRoutingModule } from './app-routing.module';
import localeFr from '@angular/common/locales/fr';
import { registerLocaleData } from '@angular/common';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { SharedModule } from '../shared/shared.module';
import { ErrorInterceptor } from './interceptors/error.interceptor';
import { StudentModule } from '../modules/student/student.module';
import { SidebarComponent } from './components/sidebar/sidebar.component';
import { MenuComponent } from './components/menu/menu.component';
import { NotFoundComponent } from './components/not-found/not-found.component';
import { SuiModule } from 'ng2-semantic-ui';
import { AccordionComponent } from './components/accordion/accordion.component';
import { JwtInterceptor } from './interceptors/jwt.interceptor';
import { TitleComponent } from './components/title/title.component';
import { HeaderComponent } from './components/header/header.component';
import { BreadcrumbsComponent } from './components/breadcrumbs/breadcrumbs.component';
import { StaffModule } from '../modules/staff/staff.module';
import { ShowcaseModule } from '../modules/showcase/showcase.module';
import { ActivatedRouteSnapshot, Router } from '@angular/router';
import { VerifyEmailComponent } from './components/verify-email/verify-email.component';

// Setting to locale to 'fr'
registerLocaleData(localeFr, 'fr');

@NgModule({
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    ReactiveFormsModule,
    HttpClientModule,
    FormsModule,
    SuiModule,

    // MUST be the last imports
    ShowcaseModule,
    StudentModule,
    StaffModule,
    SharedModule,
    AppRoutingModule,
  ],
  declarations: [
    AppComponent,
    SidebarComponent,
    AccordionComponent,
    MenuComponent,
    NotFoundComponent,
    TitleComponent,
    HeaderComponent,
    BreadcrumbsComponent,
    VerifyEmailComponent,
  ],
  providers: [
    Title,
    {provide: LOCALE_ID, useValue: 'fr'},
    {provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true},
    {provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true},
  ],
  bootstrap: [AppComponent]
})
export class AppModule {
  // Uncomment these following lines to display the router configuration
  // (useful to see if the routes are in the proper order)

  // constructor(router: Router) {
  //   console.log('Routes: ', JSON.stringify(router.config, undefined, 2));
  // }
}
