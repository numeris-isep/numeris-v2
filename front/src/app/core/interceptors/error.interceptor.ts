import { Injectable } from '@angular/core';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from "@angular/common/http";
import { Observable, throwError } from "rxjs";
import { catchError } from "rxjs/operators";
import { AlertService } from "../services/alert.service";

@Injectable({
  providedIn: 'root'
})
export class ErrorInterceptor implements HttpInterceptor {

  constructor(private alertService: AlertService) { }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(catchError(err => {
      this.alertService.clear();

      switch (err.status) {
        case 500:
          this.alertService.error(
            ['Le serveur a rencontré une erreur, veuillez nous contacter si le problème persiste.'],
            'Erreur',
            false,
            'main'
          );
          break;

        default:
          this.alertService.warning(
            err.error.errors,
            'Erreur',
            false,
            'main'
          );
          break;
      }

      return throwError(err.error.errors)
    }));
  }
}
