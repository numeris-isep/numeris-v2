import { Component, Input, OnInit } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import * as moment from 'moment';
import { Moment } from 'moment';
import { Invoice } from '../../../../core/classes/models/Invoice';
import { StatisticService } from '../../../../core/services/statistic.service';
import { PayslipAmount } from '../../../../core/classes/payslip-amount';
import { InvoiceAmount } from '../../../../core/classes/invoice-amount';

@Component({
  selector: 'app-accounting-summary',
  templateUrl: './accounting-summary.component.html',
  styleUrls: ['./accounting-summary.component.css'],
})
export class AccountingSummaryComponent implements OnInit {

  @Input() statisticByMonth: {
    month: string,
    payslips: Payslip[],
    invoices: Invoice[],
  };
  @Input() isLink: boolean = false;

  month: Moment;

  payslipAmounts: PayslipAmount;
  invoiceAmounts: InvoiceAmount;

  constructor(private statisticService: StatisticService) { }

  ngOnInit() {
    this.month = moment(this.statisticByMonth.month);
    this.calculate();
  }

  calculate() {
    this.payslipAmounts = this.statisticService
      .calculatePayslipAmounts(this.statisticByMonth.payslips);
    this.invoiceAmounts = this.statisticService
      .calculateInvoiceAmounts(this.statisticByMonth.invoices);
  }

}
