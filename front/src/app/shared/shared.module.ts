import { NgModule } from '@angular/core';
import { CommonModule  } from '@angular/common';
import { AlertComponent } from './components/alert/alert.component';
import { FooterComponent } from './components/footer/footer.component';
import { PodiumComponent } from './components/podium/podium.component';
import { TeamComponent } from './components/team/team.component';
import { SuiModule } from 'ng2-semantic-ui';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ButtonContentComponent } from './components/button/button-content/button-content.component';
import { ButtonComponent } from './components/button/button/button.component';
import { LinkButtonComponent } from './components/button/link-button/link-button.component';
import { AlertService } from '../core/services/alert.service';
import { LoaderComponent } from './components/loader/loader.component';
import { ContentComponent } from './components/content/content.component';
import { AddressPipe } from './pipes/address.pipe';
import { PhonePipe } from './pipes/phone.pipe';
import { EmptyComponent } from './components/empty/empty.component';
import { RolePipe } from './pipes/role.pipe';
import { RouterModule } from '@angular/router';
import { StatusPipe } from './pipes/status.pipe';
import { FormErrorComponent } from './components/form-error/form-error.component';
import { PaginationCaptionComponent } from './components/pagination-caption/pagination-caption.component';
import { ConventionDetailsComponent } from '../modules/staff/client/convention-details/convention-details.component';
import { AddressFormComponent } from './components/forms/address-form/address-form.component';
import { UserFormComponent } from './components/forms/user-form/user-form.component';
import { PasswordFormComponent } from './components/forms/password-form/password-form.component';
import { ProfileFormComponent } from './components/forms/profile-form/profile-form.component';
import { CountryCodePipe } from './pipes/country-code.pipe';
import { IbanPipe } from './pipes/iban.pipe';
import { SocialInsuranceNumberPipe } from './pipes/social-insurance-number.pipe';

@NgModule({
  imports: [
    RouterModule,
    CommonModule,
    SuiModule,
    FormsModule,
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
    PaginationCaptionComponent,
    ConventionDetailsComponent,
    AddressFormComponent,
    UserFormComponent,
    PasswordFormComponent,
    ProfileFormComponent,
    CountryCodePipe,
    IbanPipe,
    SocialInsuranceNumberPipe,
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
    PaginationCaptionComponent,
    ConventionDetailsComponent,

    // Pipes
    AddressPipe,
    PhonePipe,
    RolePipe,
    StatusPipe,
    AddressFormComponent,
    UserFormComponent,
    PasswordFormComponent,
    ProfileFormComponent,
    IbanPipe,
    SocialInsuranceNumberPipe,
    CountryCodePipe,
  ],
  providers: [
    AlertService
  ]
})
export class SharedModule { }
