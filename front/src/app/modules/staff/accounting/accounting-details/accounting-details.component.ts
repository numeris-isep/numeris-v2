import { Component, Input, OnInit } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import { Invoice } from '../../../../core/classes/models/Invoice';
import { StatisticService } from '../../../../core/services/statistic.service';
import { PayslipAmount } from '../../../../core/classes/payslip-amount';
import { InvoiceAmount } from '../../../../core/classes/invoice-amount';

@Component({
  selector: 'app-accounting-details',
  templateUrl: './accounting-details.component.html',
})
export class AccountingDetailsComponent implements OnInit {

  @Input() statisticByMonth: {
    month: string,
    payslips: Payslip[],
    invoices: Invoice[],
  };

  payslipAmounts: PayslipAmount;
  invoiceAmounts: InvoiceAmount;

  constructor(private statisticService: StatisticService) { }

  ngOnInit() {
    this.calculate();
  }

  calculate() {
    this.payslipAmounts = this.statisticService
      .calculatePayslipAmounts(this.statisticByMonth.payslips);
    this.invoiceAmounts = this.statisticService
      .calculateInvoiceAmounts(this.statisticByMonth.invoices);
  }

}
