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
      const error = err.error.error;
      const status = err.status;
      const url = err.url;

      let title: string = null;
      let message: string;
      let target: string;

      switch (true) {
        case status == 0:
          title = "Connexion refusée";

        case url.includes('/api/login'):
          message = status != 0
            ? error : "Nous réglons le problème";
          target = 'login-form';
          break;

        default: break;
      }

      if (message != undefined && target != undefined) {
        this.alertService.clear();
        this.alertService.error(message, title, false, target);
      }

      return throwError(error);
    }))
  }
}
