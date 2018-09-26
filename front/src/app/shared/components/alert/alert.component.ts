import { Component, Input, OnInit } from "@angular/core";
import { AlertService } from "./alert.service";
import { Alert, AlertType } from "./alert";

@Component({
  selector: 'app-alert',
  templateUrl: './alert.component.html',
  styleUrls: ['./alert.component.css']
})
export class AlertComponent implements OnInit {

  @Input() target: string = 'main';

  alerts: Alert[] = [];

  constructor(protected alertService: AlertService) { }

  ngOnInit() {
    this.alertService.getAlert().subscribe((alert: Alert) => {
      if (!alert) {
        // clear alerts when an empty alert is received
        this.alerts = [];
        return;
      }

      // add alert to array
      this.alerts.push(alert);
    });
  }

  removeAlert(alert: Alert) {
    this.alerts = this.alerts.filter(x => x !== alert);
  }

  cssClass(alert: Alert) {
    if (!alert) {
      return;
    }

    // return css class based on alert type
    switch (alert.type) {
      case AlertType.Success:
        return 'success';
      case AlertType.Info:
        return 'info';
      case AlertType.Warning:
        return 'warning';
      case AlertType.Error:
        return 'error';
    }
  }
}
