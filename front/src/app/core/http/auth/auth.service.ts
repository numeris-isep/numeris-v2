import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { first, map } from 'rxjs/operators';
import { TokenService } from '../../services/token.service';
import { environment } from '../../../../environments/environment';
import { Observable } from 'rxjs/internal/Observable';
import { BehaviorSubject } from 'rxjs';
import { User } from '../../classes/models/user';
import { HTTP_OPTIONS } from '../../constants/http_options';
import { AlertService } from '../../services/alert.service';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private loggedIn = new BehaviorSubject<boolean>(this.tokenService.isValid());

  constructor(
    private http: HttpClient,
    private tokenService: TokenService,
    private alertService: AlertService
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

  subscribe(user: User) {
    return this.http.post(`${environment.apiUrl}/api/subscribe`, user);
  }

  getCurrentUser(): Observable<User> {
    const url = `${environment.apiUrl}/api/current-user`;
    return this.http.post<User>(url, {}, HTTP_OPTIONS);
  }

  getCurrentUserId(): number {
    return this.tokenService.getCurrentUserId();
  }

  getCurrentUserRole(): string {
    return this.tokenService.getCurrentUserRole();
  }

  get isLoggedIn(): Observable<boolean> {
    return this.loggedIn.asObservable();
  }

  logout() {
    if (this.tokenService.get()) {
      this.tokenService.remove();
      this.loggedIn.next(false);
      this.alertService.success(['Déconnecté avec succès !'], null, true);
    }
  }

  forgotPassword(email: string): Observable<{message: string[]}> {
    const url = `${environment.apiUrl}/api/password/forgot`;
    return this.http.post<{message: string[]}>(url, {email: email}, HTTP_OPTIONS);
  }

  resetPassword(
    data: {
      email: string,
      password: string,
      password_confirmation: string,
      token: string,
    }
  ): Observable<{message: string[]}> {
    const url = `${environment.apiUrl}/api/password/reset`;
    return this.http.post<{message: string[]}>(url, data, HTTP_OPTIONS);
  }

  verifyEmail(): Observable<{message: string[]}> {
    const url = `${environment.apiUrl}/api/email/resend`;
    return this.http.get<{message: string[]}>(url, HTTP_OPTIONS);
  }

  validateEmail(
    data: {
      expires: string;
      id: string;
      signature: string;
    }
  ): Observable<{message: string[]}> {
    const url = `${environment.apiUrl}/api/email/verify?expires=${data.expires}&id=${data.id}&signature=${data.signature}`;
    return this.http.get<{message: string[]}>(url, HTTP_OPTIONS);
  }
}
