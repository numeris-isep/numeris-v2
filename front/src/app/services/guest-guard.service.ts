import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot } from "@angular/router";
import { Observable } from "rxjs/internal/Observable";
import { TokenService } from "./token.service";

@Injectable({
  providedIn: 'root'
})
export class GuestGuardService implements CanActivate{

  constructor(private tokenService: TokenService, private router: Router) { }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean | Observable<boolean> | Promise<boolean> {
    return !this.tokenService.isValid();
  }
}
