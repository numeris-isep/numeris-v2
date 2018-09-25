import { Injectable } from '@angular/core';
import { NavigationStart, Router } from '@angular/router';
import { Observable, Subject } from 'rxjs';
import { Alert, AlertType } from "./alert";

@Injectable({
  providedIn: 'root'
})
export class AlertService {

  private subject = new Subject<Alert>();
  private keepAfterRouteChange = false;

  constructor(private router: Router) {
    // clear alert messages on route change unless 'keepAfterRouteChange' flag is true
    router.events.subscribe(event => {
      if (event instanceof NavigationStart) {
        if (this.keepAfterRouteChange) {
          // only keep for a single route change
          this.keepAfterRouteChange = false;
        } else {
          // clear alert messages
          this.clear();
        }
      }
    });
  }

  getAlert(): Observable<any> {
    return this.subject.asObservable();
  }

  alert(type: AlertType, content: string, title: string | null, keepAfterRouteChange = false) {
    this.keepAfterRouteChange = keepAfterRouteChange;
    this.subject.next(<Alert> { type: type, content: content, title: title });
  }

  success(content: string, title: string | null = null, keepAfterRouteChange = false) {
    this.alert(AlertType.Success, content, title, keepAfterRouteChange);
  }

  info(content: string, title: string | null = null, keepAfterRouteChange = false) {
    this.alert(AlertType.Info, content, title, keepAfterRouteChange);
  }

  warning(content: string, title: string | null = null, keepAfterRouteChange = false) {
    this.alert(AlertType.Warning, content, title, keepAfterRouteChange);
  }

  error(content: string, title: string | null = null, keepAfterRouteChange = false) {
    this.alert(AlertType.Error, content, title, keepAfterRouteChange);
  }

  clear() {
    // clear alerts
    this.subject.next();
  }
}
