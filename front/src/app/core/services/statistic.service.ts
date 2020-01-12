import { Injectable } from '@angular/core';
import { Payslip } from '../classes/models/payslip';
import { Invoice } from '../classes/models/Invoice';
import { PayslipAmount } from '../classes/payslip-amount';
import { InvoiceAmount } from '../classes/invoice-amount';

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
      employerDeductionAmounts: 0,
      count: 0,
    };
  }

  initInvoiceAmount() {
    this.invoiceAmount = {
      hourAmounts: 0,
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
      this.payslipAmounts.count++;
    });

    return this.payslipAmounts;
  }

  calculateInvoiceAmounts(invoices: Invoice[]): InvoiceAmount {
    this.initInvoiceAmount();

    invoices.forEach(invoice => {
      this.invoiceAmount.hourAmounts += parseFloat(invoice.hourAmount.toString());
      this.invoiceAmount.grossAmounts += parseFloat(invoice.grossAmount.toString());
      this.invoiceAmount.vatAmounts += parseFloat(invoice.vatAmount.toString());
      this.invoiceAmount.finalAmounts += parseFloat(invoice.finalAmount.toString());
    });

    return this.invoiceAmount;
  }
}
