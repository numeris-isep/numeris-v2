import { Injectable } from '@angular/core';
import { Router, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { map, take } from "rxjs/operators";
import { AuthService } from "./auth.service";
import { SuiModalService } from "ng2-semantic-ui";
import { LoginModal } from "../shared/modals/login-modal/login-modal.component";

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {

  private modal: LoginModal = new LoginModal();

  constructor(
    private router: Router,
    private authService: AuthService,
    private modalService: SuiModalService
  ) { }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    return this.authService.isLoggedIn
      .pipe(
        take(1),
        map((isLoggedIn: boolean) => {
          if (!isLoggedIn) {
            // not logged in so redirect to home page with the return url
            this.router.navigate(['/'], { queryParams: { returnUrl: state.url }});
            this.modalService.open(this.modal);
            return false;
          }
          return true;
        })
      )
  }
}
