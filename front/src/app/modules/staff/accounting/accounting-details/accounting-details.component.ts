import { Component, Input, OnInit } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import * as moment from 'moment';
import { Moment } from 'moment';
import { PayslipService } from '../../../../core/http/payslip.service';
import { AlertService } from '../../../../core/services/alert.service';
import { FileService } from '../../../../core/http/file.service';
import { Invoice } from '../../../../core/classes/models/Invoice';

@Component({
  selector: 'app-accounting-details',
  templateUrl: './accounting-details.component.html',
  styleUrls: ['./accounting-details.component.css'],
})
export class AccountingDetailsComponent implements OnInit {

  @Input() statisticByMonth: {
    month: string,
    payslips: Payslip[],
    invoices: Invoice[],
  };
  @Input() isLink: boolean = false;

  month: Moment;

  hourAmount: number = 0;
  grossAmount: number = 0;
  subscriptionFee: number = 0;
  clientFinalAmount: number = 0;

  hourCount: any;
  grossCount: any;
  subscriptionFeeCount: any;
  clientFinalCount: any;

  // loading: boolean = false;
  // zipLoading: boolean = false;

  constructor() { }

  ngOnInit() {
    this.month = moment(this.statisticByMonth.month);
    this.calculate();
  }

  calculate() {
    this.calculatePayslipAmounts();
    this.calculateInvoiceAmounts();
  }

  calculatePayslipAmounts() {
    this.statisticByMonth.payslips.forEach(payslip => {
      this.hourAmount += parseInt(payslip.hourAmount.toString());
      this.grossAmount += parseInt(payslip.grossAmount.toString());
      this.subscriptionFee += parseInt(payslip.subscriptionFee.toString());
    });
  }

  calculateInvoiceAmounts() {
    this.statisticByMonth.invoices.forEach(invoice => {
      this.clientFinalAmount += parseInt(invoice.finalAmount.toString());
    });
  }

  // calculate() {
  //   this.loading = true;
  //
  //   this.payslipService.updatePayslips(this.month.format('Y-MM-DD HH:mm:ss'))
  //     .subscribe(payslips => {
  //       this.statisticByMonth.payslips = payslips;
  //       this.loading = false;
  //
  //       if (payslips.length > 0) {
  //         this.alertService.success([
  //           `Les données de paiement ont bien été calculées pour ${this.month.locale('fr').format('MMMM Y')}.`
  //         ]);
  //       } else {
  //         this.alertService.warning([
  //           `Aucune donnée de paiement pour ${this.month.locale('fr').format('MMMM Y')}.`
  //         ]);
  //       }
  //     });
  // }
  //
  // downloadArchive(month: string) {
  //   this.zipLoading = true;
  //
  //   this.fileService.getArchive(month).subscribe(
  //     zip => {
  //       this.fileService.downloadFile(zip, 'application/zip');
  //       this.zipLoading = false;
  //     },
  //     error => {
  //       this.zipLoading = false;
  //     },
  //   );
  // }

}
