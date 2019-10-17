import { Injectable } from '@angular/core';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { AlertService } from '../services/alert.service';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class ErrorInterceptor implements HttpInterceptor {

  constructor(
    private alertService: AlertService,
    private router: Router,
  ) { }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(catchError(err => {
      this.alertService.clear();

      switch (err.status) {
        case 401:
          this.alertService.error(err.error.errors, null, null, 'login-form');
          break;

        case 403:
          this.alertService.error(['Vous n\'avez pas le droit d\'effectuer cette action.'], null, null);
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

        default:
          this.alertService.error(err.error.errors, 'Erreur', null);
          break;
      }

      return throwError(err.error.errors);
    }));
  }
}
