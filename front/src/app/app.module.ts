import { NgModule } from "@angular/core";
import { AppComponent } from "./app.component";
import { BrowserModule } from "@angular/platform-browser";
import { ReactiveFormsModule } from "@angular/forms";
import { HttpClientModule } from "@angular/common/http";
import { AppRoutingModule } from "./app-routing.module";
import { AlertComponent } from "./_directives/alert.component";
import { AlertService } from "./_services/alert.service";
import { AuthGuard } from "./_guards/auth.service";
import { LoginComponent } from "./login/login.component";
import { AuthService } from "./_services/auth.service";
import { ProfileComponent } from './profile/profile.component';

@NgModule({
  imports: [
    BrowserModule,
    ReactiveFormsModule,
    HttpClientModule,
    AppRoutingModule
  ],
  declarations: [
    AppComponent,
    AlertComponent,
    LoginComponent,
    ProfileComponent
  ],
  providers: [
    AuthGuard,
    AlertService,
    AuthService,
  ],
  bootstrap: [AppComponent]
})

export class AppModule { }
