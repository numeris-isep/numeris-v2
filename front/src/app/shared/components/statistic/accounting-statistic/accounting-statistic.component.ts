import { Component, Input, OnInit } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import { Invoice } from '../../../../core/classes/models/Invoice';

@Component({
  selector: 'app-accounting-statistic',
  templateUrl: './accounting-statistic.component.html'
})
export class AccountingStatisticComponent implements OnInit {

  @Input() payslips: Payslip[] = [];
  @Input() invoices: Invoice[] = [];

  hourAmount: number = 0;
  grossAmount: number = 0;
  subscriptionFee: number = 0;
  clientFinalAmount: number = 0;

  hourCount: any;
  grossCount: any;
  subscriptionFeeCount: any;
  clientFinalCount: any;

  constructor() { }

  ngOnInit() {
    this.calculate();
  }

  calculate() {
    this.calculatePayslipAmounts();
    this.calculateInvoiceAmounts();
  }

  calculatePayslipAmounts() {
    this.payslips.forEach(payslip => {
      this.hourAmount += parseInt(payslip.hourAmount.toString());
      this.grossAmount += parseInt(payslip.grossAmount.toString());
      this.subscriptionFee += parseInt(payslip.subscriptionFee.toString());
    });
  }

  calculateInvoiceAmounts() {
    this.invoices.forEach(invoice => {
      this.clientFinalAmount += parseInt(invoice.finalAmount.toString());
    });
  }
}
