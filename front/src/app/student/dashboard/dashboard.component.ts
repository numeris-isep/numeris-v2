import { Component, OnInit } from '@angular/core';
import { AlertService } from "../../shared/alert/alert.service";

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html'
})
export class DashboardComponent implements OnInit {

  constructor(private alertService: AlertService) { }

  ngOnInit() {
  }

  success(content: string, title: string | null = null) {
    this.alertService.success(content, title, true);
  }

  error(content: string, title: string | null = null) {
    this.alertService.error(content, title);
  }

  info(content: string, title: string | null = null) {
    this.alertService.info(content, title);
  }

  warning(content: string, title: string | null = null) {
    this.alertService.warning(content, title);
  }

  clear() {
    this.alertService.clear();
  }
}
