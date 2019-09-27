import { Component, OnInit } from '@angular/core';
import * as moment from 'moment';
import { Payslip } from '../../../core/classes/models/payslip';
import { PayslipService } from '../../../core/http/payslip.service';

@Component({
  selector: 'app-accounting',
  templateUrl: './accounting.component.html',
})
export class AccountingComponent implements OnInit {

  loading: boolean = false;
  selectedYear: string = moment().format('Y');
  years: string[] = [];

  payslipsByMonth: {
    month: string,
    payslips: Payslip[]
  }[];

  constructor(private payslipService: PayslipService) { }

  ngOnInit() {
    this.initYears();

    this.selectYear(this.selectedYear);
  }

  initYears() {
    let currentYear = moment().get('year');

    for (let i = 2019; i <= moment().get('year'); i++) {
      this.years.push(i.toString());
      currentYear++;
    }
  }

  initPayslipsByMonth() {
    this.payslipsByMonth = [];

    for (let i = 1; i <= 12; i++) {
      this.payslipsByMonth.push({
        month: `${this.selectedYear}-${('0' + i).slice(-2)}-01 00:00:00`,
        payslips: []
      });
    }
  }

  getPayslips() {
    this.loading = true;

    this.payslipService.getPayslips(this.selectedYear).subscribe(payslips => {
      payslips.map(payslip => {
        this.payslipsByMonth[parseInt(moment(payslip.month).format('M')) - 1].payslips.push(payslip);
      });
      this.loading = false;
    });
  }

  selectYear(year: string) {
    this.selectedYear = year;

    this.initPayslipsByMonth();
    this.getPayslips();
  }

}
