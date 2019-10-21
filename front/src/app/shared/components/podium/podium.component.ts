import { Component, Input, OnInit, ViewChild } from '@angular/core';
import * as moment from 'moment';
import { Moment } from 'moment';
import { PayslipService } from '../../../core/http/payslip.service';
import { Payslip } from '../../../core/classes/models/payslip';
import { ScrollService } from '../../../core/services/scroll.service';
import { ConfettiService, ConfettiType } from '../../../core/services/confetti.service';

@Component({
  selector: 'app-podium',
  templateUrl: './podium.component.html',
  styleUrls: ['./podium.component.css']
})
export class PodiumComponent implements OnInit {

  @ViewChild('template') template;
  @ViewChild('canvas') canvas;

  @Input() date: Moment = moment().subtract(1, 'month').startOf('month');
  @Input() page: string = 'not-home';

  initializedPayslips: Payslip[];
  payslips: Payslip[];
  fetched: boolean = false;

  hour0Count;
  hour1Count;
  hour2Count;

  constructor(
    private payslipService: PayslipService,
    private scrollService: ScrollService,
    private confettiService: ConfettiService,
  ) { }

  ngOnInit() {
    this.getPayslips();

    if (this.page === 'home') {
      this.scrollService.scrollPosition.subscribe(y => {
        if (! this.fetched && y >= this.template.nativeElement.getBoundingClientRect().y + 400) {
          this.setPayslips();
          this.fetched = true;
        }
      });
    }
  }

  getPayslips() {
    this.payslipService.getPodium(this.date.format('Y-MM-DD HH:mm:ss')).subscribe(payslips => {
      this.initializedPayslips = payslips;

      if (this.page !== 'home') { this.setPayslips(); }
    });
  }

  setPayslips() {
    this.payslips = this.initializedPayslips;
  }

  shootConfetti() {
    this.confettiService.shoot(ConfettiType.SchoolPride, this.canvas.nativeElement);
  }

}
