import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { SuiModule } from 'ng2-semantic-ui';
import { ReactiveFormsModule } from '@angular/forms';
import { HomeComponent } from './home/home.component';
import { ContactUsModalComponent } from './modals/contact-us-modal/contact-us-modal.component';
import { LoginModalComponent } from './modals/login-modal/login-modal.component';
import { SharedModule } from '../../shared/shared.module';
import { SubscribeModalComponent } from './modals/subscribe-modal/subscribe-modal.component';
import { ResetPasswordComponent } from './reset-password/reset-password.component';
import { ShowcaseRoutingModule } from './showcase-routing.module';
import { RecaptchaModule } from 'ng-recaptcha';

@NgModule({
  imports: [
    RouterModule,
    CommonModule,
    SuiModule,
    ReactiveFormsModule,
    ShowcaseRoutingModule,
    SharedModule,
    RecaptchaModule,
  ],
  declarations: [
    HomeComponent,
    LoginModalComponent,
    ContactUsModalComponent,
    SubscribeModalComponent,
    ResetPasswordComponent,
  ],
  entryComponents: [
    LoginModalComponent,
    SubscribeModalComponent,
    ContactUsModalComponent,
  ]
})
export class ShowcaseModule { }
