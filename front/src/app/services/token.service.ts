import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class TokenService {

  private tokenName: string = 'numeris_v2_token';

  private iss = {
    login: 'http://localhost:8000/api/login'
  };

  constructor() { }

  handle(token) {
    this.set(token);
    console.log(this.isValid(token));
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
  isValid(token) {
    if (this.get()) {
      const payload = this.payload(token);

      if (payload) {
        return payload.iss === this.iss.login;
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

  /**
   * Check if the user is logged in
   *
   * @param token
   * @returns {boolean}
   */
  loggedIn(token) {
    return this.isValid(token);
  }
}
