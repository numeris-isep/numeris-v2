import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, RouterStateSnapshot, UrlTree } from '@angular/router';
import { AuthService } from "../http/auth/auth.service";
import { map, take } from "rxjs/operators";
import { User } from "../classes/models/user";

@Injectable({
  providedIn: 'root'
})
export class ActivatedGuard implements CanActivate  {

  constructor(private authService: AuthService) { }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    return this.authService.getCurrentUser().pipe(
      take(1),
      map((user: User) => {
        return user.activated && user.touAccepted;
      }
    ));
  }

}
