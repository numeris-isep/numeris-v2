import { Component, ElementRef, Input, OnInit, QueryList, ViewChildren } from '@angular/core';
import { AlertService } from '../../../core/services/alert.service';
import { Alert, AlertType } from '../../../core/classes/alert';
import { timer } from 'rxjs';
import { Transition, TransitionController, TransitionDirection } from 'ng2-semantic-ui';
import { ScrollService } from '../../../core/services/scroll.service';

@Component({
  selector: 'app-alert',
  templateUrl: './alert.component.html',
  styleUrls: ['./alert.component.css']
})
export class AlertComponent implements OnInit {

  @Input() target: string = 'main';
  @ViewChildren('container') containers: QueryList<ElementRef>;
  @ViewChildren('message') messages: QueryList<ElementRef>;

  alerts: Alert[] = [];
  position: number = 0;

  constructor(
    private alertService: AlertService,
    private scrollService: ScrollService,
  ) { }

  ngOnInit() {
    this.initAlerts();
    this.initPosition();
  }

  initAlerts() {
    this.alertService.getAlert().subscribe((alert: Alert) => {
      if (! alert) {
        // clear alerts when an empty alert is received
        this.alerts = [];
        return;
      }

      alert.transitionController = new TransitionController();

      // add alert to array
      this.alerts.push(alert);

      this.autoFade(alert);
    });
  }

  initPosition() {
    this.scrollService.scrollPosition.subscribe(position => this.position = position);
  }

  removeAlert(index: number) {
    if (this.containers.toArray()[index]) {
      this.alerts = [];
      this.containers.toArray()[index].nativeElement.remove();
    }
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

  autoFade(alert: Alert) {
    timer(8000).subscribe(() => {
      this.animate(alert, this.alerts.findIndex(a => a === alert));
    });
  }

  animate(alert, index: number) {
    alert.transitionController.animate(
      new Transition(
        'fade down',
        500,
        TransitionDirection.Out,
        () => this.removeAlert(index))
    );
  }
}
