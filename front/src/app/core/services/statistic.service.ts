import { Injectable } from '@angular/core';
import { Payslip } from '../classes/models/payslip';
import { Invoice } from '../classes/models/Invoice';

@Injectable({
  providedIn: 'root'
})
export class StatisticService {

  payslipAmounts: PayslipAmount;
  invoiceAmount: InvoiceAmount;

  constructor() { }

  initPayslipAmounts() {
    this.payslipAmounts = {
      hourAmounts: 0,
      grossAmounts: 0,
      finalAmounts: 0,
      subscriptionFees: 0,
      deductionAmounts: 0,
      employerDeductionAmounts: 0
    };
  }

  initInvoiceAmount() {
    this.invoiceAmount = {
      grossAmounts: 0,
      vatAmounts: 0,
      finalAmounts: 0,
    };
  }

  calculatePayslipAmounts(payslips: Payslip[]): PayslipAmount {
    this.initPayslipAmounts();

    payslips.forEach(payslip => {
      this.payslipAmounts.hourAmounts += parseInt(payslip.hourAmount.toString());
      this.payslipAmounts.grossAmounts += parseInt(payslip.grossAmount.toString());
      this.payslipAmounts.finalAmounts += parseInt(payslip.finalAmount.toString());
      this.payslipAmounts.subscriptionFees += parseInt(payslip.subscriptionFee.toString());
      this.payslipAmounts.deductionAmounts += parseInt(payslip.deductionAmount.toString());
      this.payslipAmounts.employerDeductionAmounts += parseInt(payslip.employerDeductionAmount.toString());
    });

    return this.payslipAmounts;
  }

  calculateInvoiceAmounts(invoices: Invoice[]): InvoiceAmount {
    this.initInvoiceAmount();

    invoices.forEach(invoice => {
      this.invoiceAmount.grossAmounts += invoice.grossAmount;
      this.invoiceAmount.vatAmounts += invoice.vatAmount;
      this.invoiceAmount.finalAmounts += invoice.finalAmount;
    });

    return this.invoiceAmount;
  }
}

export class PayslipAmount {

  hourAmounts: number;
  grossAmounts: number;
  finalAmounts: number;
  subscriptionFees: number;
  deductionAmounts: number;
  employerDeductionAmounts: number;

}

export class InvoiceAmount {

  grossAmounts: number;
  vatAmounts: number;
  finalAmounts: number;

}
