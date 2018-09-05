import { Injectable } from '@angular/core';
import { environment } from "../../environments/environment";
import * as moment from 'moment';

@Injectable({
  providedIn: 'root'
})
export class TokenService {

  private tokenName: string = environment.tokenName;

  private iss = {
    login: `${environment.apiUrl}/api/login`
  };

  constructor() { }

  handle(token) {
    this.set(token);
  }

  /**
   * Set token to the browser's local storage
   *
   * @param token
   */
  set(token) {
    localStorage.setItem(this.tokenName, token);
  }

  /**
   * Get token from local storage
   */
  get() {
    return localStorage.getItem(this.tokenName);
  }

  /**
   * Remove token
   */
  remove() {
    localStorage.removeItem(this.tokenName);
  }

  /**
   * Check if the token is valid
   *
   * @param token
   * @returns {boolean}
   */
  isValid() {
    const token = this.get();

    if (token) {
      const payload = this.payload(token);

      if (payload) {
        // To be valid, the current time be must be <= to the expiration date
        // of the token
        if (moment().unix() <= payload.exp) {
          return payload.iss === this.iss.login;
        }
      }
    }

    return false;
  }

  /**
   * Get the decrypted payload part of the JWT token
   *
   * @param token
   * @returns {string}
   */
  payload(token) {
    const payload = token.split('.')[1];

    return this.decode(payload);
  }

  /**
   * Decode a part of a token
   *
   * @param tokenPart
   * @returns {any}
   */
  decode(tokenPart) {
    return JSON.parse(atob(tokenPart));
  }
}
