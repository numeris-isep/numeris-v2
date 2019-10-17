import { Component, Input, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import { Invoice } from '../../../../core/classes/models/Invoice';
import { InvoiceAmount, PayslipAmount, StatisticService } from '../../../../core/services/statistic.service';

@Component({
  selector: 'app-accounting-statistic',
  templateUrl: './accounting-statistic.component.html'
})
export class AccountingStatisticComponent implements OnInit, OnChanges {

  @Input() payslips: Payslip[] = [];
  @Input() invoices: Invoice[] = [];

  payslipAmounts: PayslipAmount;
  invoiceAmounts: InvoiceAmount;

  hourCount: any;
  grossCount: any;
  subscriptionFeeCount: any;
  clientFinalCount: any;

  constructor(private statisticService: StatisticService) { }

  ngOnInit() {
    this.calculate(this.payslips, this.invoices);
  }

  ngOnChanges(changes: SimpleChanges) {
    this.calculate(changes.payslips.currentValue, changes.invoices.currentValue);
  }

  calculate(payslips: Payslip[], invoices: Invoice[]) {
    this.payslipAmounts = this.statisticService
      .calculatePayslipAmounts(payslips);
    this.invoiceAmounts = this.statisticService
      .calculateInvoiceAmounts(invoices);
  }

}

