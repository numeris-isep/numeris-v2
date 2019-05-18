import { Injectable } from '@angular/core';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from "@angular/common/http";
import { Observable, throwError } from "rxjs";
import { catchError } from "rxjs/operators";
import { AlertService } from "../services/alert.service";
import { Router } from "@angular/router";
import { LoginModal } from "../../modules/showcase/modals/login-modal/login-modal.component";
import { SuiModalService } from "ng2-semantic-ui";

@Injectable({
  providedIn: 'root'
})
export class ErrorInterceptor implements HttpInterceptor {

  private loginModal: LoginModal;

  constructor(
    private alertService: AlertService,
    private router: Router,
    private modalService: SuiModalService,
  ) { }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(catchError(err => {
      this.alertService.clear();

      switch (err.status) {
        case 401:
          this.loginModal = new LoginModal(
            'Veuillez vous connecter pour accéder à cette page',
            this.router.url
          );
          this.modalService.open(this.loginModal);
          break;

        case 403:
          this.alertService.error(err.error.errors);
          break;

        case 404:
          this.router.navigate(['/page-inconnue']);
          break;

        case 500:
          this.alertService.error(
            ['Le serveur a rencontré une erreur, veuillez nous contacter si le problème persiste.'],
            'Erreur',
            false,
            'main'
          );
          break;

        default: break;
      }

      return throwError(err.error.errors);
    }));
  }
}
