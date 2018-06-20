import { BrowserModule } from "@angular/platform-browser";
import { ReactiveFormsModule } from "@angular/forms";
import { HTTP_INTERCEPTORS, HttpClientModule } from "@angular/common/http";
import { AppRoutingModule } from "./app-routing.module";
import { AppComponent } from "./app.component";
import { LoginComponent } from "./login/login.component";
import { AlertComponent } from "./_directives/alert.component";
import { HomeComponent } from "./home/home.component";
import { AuthGuard } from "./_guards/auth.service";
import { AlertService } from "./_services/alert.service";
import { AuthService } from "./_services/auth.service";
import { UserService } from "./_services/user.service";
import { JwtInterceptor } from "./_helpers/jwt-interceptor.service";
import { NgModule } from "@angular/core";

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
    HomeComponent,
    LoginComponent
  ],
  providers: [
    AuthGuard,
    AlertService,
    AuthService,
    UserService,
    {
      provide: HTTP_INTERCEPTORS,
      useClass: JwtInterceptor,
      multi: true
    },

    // provider used to create fake backend
    // fakeBackendProvider
  ],
  bootstrap: [AppComponent]
})

export class AppModule { }
