import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class StringService {

  constructor() { }

  /**
   * helloWorld --> hello-world
   */
  static camelCaseToDash(str: string): string {
    return str.replace(/([A-Z])/g, (g) => g[0].toLowerCase());
  }

  /**
   * hello-world --> helloWorld
   */
  static dashCaseToCamel(str: string): string {
    return str.replace(/-([a-z])/g, (g) => g[1].toUpperCase());
  }
}
