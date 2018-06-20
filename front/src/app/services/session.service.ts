import { Injectable } from '@angular/core';
import { BehaviorSubject } from "rxjs/internal/BehaviorSubject";
import { TokenService } from "./token.service";

@Injectable({
  providedIn: 'root'
})
export class SessionService {

  private loggedIn = new BehaviorSubject<boolean>(this.tokenService.isValid());

  authStatus = this.loggedIn.asObservable();

  constructor(private tokenService: TokenService) { }

  changeAuthStatus(value: boolean) {
    this.loggedIn.next(value);
  }
}
