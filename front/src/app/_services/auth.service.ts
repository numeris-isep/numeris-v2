import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { TokenService } from "./token.service";
import { environment } from "../../environments/environment";
import { Observable } from "rxjs/internal/Observable";
import { User } from "../_models/user";
import { HTTP_OPTIONS } from "../_constants/http-options";

@Injectable({
  providedIn: 'root'
})
export class AuthService {
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
        }
      }));
  }

  getCurrentUser(): Observable<User> {
    const url = `${environment.apiUrl}/api/current-user`;
    return this.http.post<User>(url, {}, HTTP_OPTIONS);
  }

  logout() {
    this.tokenService.remove();
  }
}
