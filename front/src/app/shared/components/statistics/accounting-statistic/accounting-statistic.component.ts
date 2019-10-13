import { Component, Input, OnInit } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import { Invoice } from '../../../../core/classes/models/Invoice';
import { InvoiceAmount, PayslipAmount, StatisticService } from '../../../../core/services/statistic.service';

@Component({
  selector: 'app-accounting-statistic',
  templateUrl: './accounting-statistic.component.html'
})
export class AccountingStatisticComponent implements OnInit {

  @Input() payslips: Payslip[] = [];
  @Input() invoices: Invoice[] = [];

  payslipAmounts: PayslipAmount;
  invoiceAmounts: InvoiceAmount;

  hourCount: any;
  grossCount: any;
  subscriptionFeeCount: any;
  clientFinalCount: any;

  constructor(private statisticService: StatisticService) {
  }

  ngOnInit() {
    this.calculate();
  }

  calculate() {
    this.payslipAmounts = this.statisticService
      .calculatePayslipAmounts(this.payslips);
    this.invoiceAmounts = this.statisticService
      .calculateInvoiceAmounts(this.invoices);
  }

}

