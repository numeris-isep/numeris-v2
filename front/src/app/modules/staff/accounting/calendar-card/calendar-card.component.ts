import { Component, Input, OnInit } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import * as moment from 'moment';
import { Moment } from 'moment';
import { PayslipService } from '../../../../core/http/payslip.service';
import { AlertService } from '../../../../core/services/alert.service';
import { FileService } from '../../../../core/http/file.service';

@Component({
  selector: 'app-calendar-card',
  templateUrl: './calendar-card.component.html'
})
export class CalendarCardComponent implements OnInit {

  @Input() payslipByMonth: {
    month: string,
    payslips: Payslip[]
  };
  month: Moment;
  loading: boolean = false;
  zipLoading: boolean = false;

  constructor(
    private payslipService: PayslipService,
    private fileService: FileService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.month = moment(this.payslipByMonth.month);
  }

  calculate() {
    this.loading = true;

    this.payslipService.updatePayslips(this.month.format('Y-MM-DD HH:mm:ss'))
      .subscribe(payslips => {
        this.payslipByMonth.payslips = payslips;
        this.loading = false;

        if (payslips.length > 0) {
          this.alertService.success([
            `Les données de paiement ont bien été calculées pour ${this.month.locale('fr').format('MMMM Y')}.`
          ]);
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
