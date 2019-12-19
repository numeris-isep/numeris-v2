import { LOCALE_ID, NgModule, OnInit } from '@angular/core';
import { AppComponent } from './app.component';
import { BrowserModule, Title } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HTTP_INTERCEPTORS, HttpClientModule } from '@angular/common/http';
import { AppRoutingModule } from './app-routing.module';
import localeFr from '@angular/common/locales/fr';
import { registerLocaleData, TitleCasePipe } from '@angular/common';
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
import { VerifyEmailComponent } from './components/verify-email/verify-email.component';
import { Router } from '@angular/router';
import { ServiceWorkerModule } from '@angular/service-worker';
import { environment } from '../../environments/environment';

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
    ServiceWorkerModule.register('ngsw-worker.js', { enabled: environment.production }),
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
    TitleCasePipe,
    {provide: LOCALE_ID, useValue: 'fr'},
    {provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true},
    {provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true},
  ],
  bootstrap: [AppComponent]
})
export class AppModule {

  constructor(private router: Router) {
    // Uncomment the following line to display the router configuration (useful to see if the routes are in the proper order)
    // console.log('Routes: ', JSON.stringify(router.config, undefined, 2));
  }
}
