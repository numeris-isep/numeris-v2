import { Component, OnInit } from '@angular/core';
import * as moment from 'moment';
import { Moment } from 'moment';
import { PayslipService } from '../../../../core/http/payslip.service';
import { Payslip } from '../../../../core/classes/models/payslip';
import { PayslipAmount } from '../../../../core/classes/payslip-amount';
import { StatisticService } from '../../../../core/services/statistic.service';

@Component({
  selector: 'app-dares-statistic',
  templateUrl: './dares-statistic.component.html',
  styleUrls: ['./dares-statistic.component.css']
})
export class DaresStatisticComponent implements OnInit {

  selectedYear: Moment = moment();
  payslips: Payslip[];
  payslipByTrimester: {
    range: {from: Moment, to: Moment},
    payslipAmount: PayslipAmount;
  }[];

  loading: boolean = false;

  constructor(
    private payslipService: PayslipService,
    private statisticService: StatisticService,
  ) { }

  ngOnInit() {
    this.getPayslips();
  }

  getPayslips() {
    this.loading = true;

    this.payslipService.getPayslips(this.selectedYear.get('year').toString()).subscribe(payslips => {
      this.payslips = payslips;

      this.initTrimesters();
      this.loading = false;
    });
  }

  initTrimesters() {
    this.payslipByTrimester = [];

    for (let i = 0; i <= 9; i += 3) {
      const from = moment({y: this.selectedYear.get('year'), M: i});
      const to = i !== 9
        ? moment({y: this.selectedYear.get('year'), M: i + 3})
        : moment({y: this.selectedYear.clone().add(1, 'year').get('year'), M: 0});
      const payslips: Payslip[] = this.payslips.filter(payslips => moment(payslips.month).isBetween(from, to, null, '[)'));

      this.payslipByTrimester.push(
        {
          range: {from: from, to: to},
          payslipAmount: this.statisticService.calculatePayslipAmounts(payslips),
        }
      );
    }
  }

  changeYear(operation: string) {
    this.selectedYear[operation](1, 'year');
    this.getPayslips();
  }

}
