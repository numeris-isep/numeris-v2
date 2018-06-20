import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { TokenService } from "./token.service";

@Injectable()
export class AuthService {
  constructor(
    private http: HttpClient,
    private tokenService: TokenService
  ) { }

  login(email: string, password: string) {
    return this.http.post<any>('http://localhost:8000/api/login', { email: email, password: password });
  }

  logout() {
    this.tokenService.remove();
  }
}
