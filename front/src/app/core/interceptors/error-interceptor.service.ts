import { Injectable } from '@angular/core';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from "@angular/common/http";
import { Observable, throwError } from "rxjs";
import { catchError } from "rxjs/operators";
import { AlertService } from "../services/alert.service";

@Injectable({
  providedIn: 'root'
})
export class ErrorInterceptorService implements HttpInterceptor {

  constructor(private alertService: AlertService) { }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(catchError(err => {
      const error = err.error.error;
      const url = err.url;

      switch (true) {
        case url.includes('/api/login'):
          this.alertService.error(error, null, false, 'login-form');
          break;

        default: break;
      }

      return throwError(error);
    }))
  }
}
