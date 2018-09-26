import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { TokenService } from "../services/token.service";
import { environment } from "../../../environments/environment";
import { Observable } from "rxjs/internal/Observable";
import { BehaviorSubject } from "rxjs";
import { User } from "../classes/models/user";
import { HTTP_OPTIONS } from "../constants/http_options";
import { Router } from "@angular/router";
import { AlertService } from "../../shared/components/alert/alert.service";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private loggedIn = new BehaviorSubject<boolean>(this.tokenService.isValid());

  constructor(
    private http: HttpClient,
    private tokenService: TokenService
  ) { }

  login(email: string, password: string) {
    return this.http.post<any>(`${environment.apiUrl}/api/login`, { email: email, password: password })
      .pipe(map((response: any) => {
        if (response && response.access_token) {
          // store username and jwt token in local storage to keep user logged in between page refreshes
          this.tokenService.set(response.access_token);
          this.loggedIn.next(true);
        }
      }));
  }

  getCurrentUser(): Observable<User> {
    const url = `${environment.apiUrl}/api/current-user`;
    return this.http.post<User>(url, {}, HTTP_OPTIONS);
  }

  get isLoggedIn(): Observable<boolean> {
    return this.loggedIn.asObservable();
  }

  logout() {
    if (this.tokenService.get()) {
      this.tokenService.remove();
      this.loggedIn.next(false);
    }
  }
}
