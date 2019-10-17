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
      this.payslipAmounts.hourAmounts += parseFloat(payslip.hourAmount.toString());
      this.payslipAmounts.grossAmounts += parseFloat(payslip.grossAmount.toString());
      this.payslipAmounts.finalAmounts += parseFloat(payslip.finalAmount.toString());
      this.payslipAmounts.subscriptionFees += parseFloat(payslip.subscriptionFee.toString());
      this.payslipAmounts.deductionAmounts += parseFloat(payslip.deductionAmount.toString());
      this.payslipAmounts.employerDeductionAmounts += parseFloat(payslip.employerDeductionAmount.toString());
    });

    return this.payslipAmounts;
  }

  calculateInvoiceAmounts(invoices: Invoice[]): InvoiceAmount {
    this.initInvoiceAmount();

    invoices.forEach(invoice => {
      this.invoiceAmount.grossAmounts += parseFloat(invoice.grossAmount.toString());
      this.invoiceAmount.vatAmounts += parseFloat(invoice.vatAmount.toString());
      this.invoiceAmount.finalAmounts += parseFloat(invoice.finalAmount.toString());
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
