import { Component, Input, OnInit } from '@angular/core';
import { AlertService } from '../../../../core/services/alert.service';
import { FileService } from '../../../../core/http/file.service';
import { Payslip } from '../../../../core/classes/models/payslip';
import { Invoice } from '../../../../core/classes/models/Invoice';
import { PayslipService } from '../../../../core/http/payslip.service';
import { Moment } from 'moment';
import * as moment from 'moment';
import { Router } from '@angular/router';

@Component({
  selector: 'app-accounting-actions',
  templateUrl: './accounting-actions.component.html',
  styleUrls: ['./accounting-actions.component.css']
})
export class AccountingActionsComponent implements OnInit {

  @Input() statisticByMonth: {
    month: string,
    payslips: Payslip[],
    invoices: Invoice[],
  };
  month: Moment;

  loading: boolean = false;
  zipLoading: boolean = false;

  constructor(
    private payslipService: PayslipService,
    private fileService: FileService,
    private alertService: AlertService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.month = moment(this.statisticByMonth.month);
  }

  calculateStatistics() {
    this.loading = true;

    this.payslipService.updatePayslips(this.month.format('Y-MM-DD HH:mm:ss'))
      .subscribe(payslips => {
        this.statisticByMonth.payslips = payslips;
        this.loading = false;

        if (payslips.length > 0) {
          this.router.navigate(['/'])
            .then(() => { this.router.navigate([`/comptabilite/${this.month.format('Y/MM')}`]); } );

          this.alertService.success([
            `Les données de paiement ont bien été calculées pour ${this.month.locale('fr').format('MMMM Y')}.`
          ], null, true);
        } else {
          this.alertService.warning([
            `Aucune donnée de paiement pour ${this.month.locale('fr').format('MMMM Y')}.`
          ]);
        }
      });
  }

  downloadArchive(month: string) {
    this.zipLoading = true;

    this.fileService.getArchive(month).subscribe(
      zip => {
        this.fileService.downloadFile(zip, 'application/zip');
        this.zipLoading = false;
      },
      error => {
        this.zipLoading = false;
      },
    );
  }

}
