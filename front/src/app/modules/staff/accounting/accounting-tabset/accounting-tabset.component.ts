import { Component, Input, OnInit } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import { Invoice } from '../../../../core/classes/models/Invoice';
import { PayslipService } from '../../../../core/http/payslip.service';
import { AlertService } from '../../../../core/services/alert.service';

@Component({
  selector: 'app-accounting-tabset',
  templateUrl: './accounting-tabset.component.html'
})
export class AccountingTabsetComponent implements OnInit {

  @Input() documents: {
    month: string,
    payslips: Payslip[],
    invoices: Invoice[],
  };

  loading: boolean = false;

  massAction: { signed: boolean, paid: boolean } = { signed: false, paid: false };

  constructor(
    private payslipService: PayslipService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
  }

  markAllAs(field: string) {
    this.loading = true;

    const payslips = this.documents.payslips;
    const data: { id: number, signed?: boolean, paid?: boolean }[] = payslips.map(payslip => {
      const object = {id: payslip.id};
      object[field] = this.massAction[field];

      return object;
    });

    this.payslipService.updatePayslipsPartially(data).subscribe(
      () => {
        this.documents.payslips.forEach(payslip => {
          payslip[field] = this.massAction[field];
        });
        this.loading = false;
      },
      () => {
        this.massAction[field] = ! this.massAction[field];
        this.alertService.error(['Impossible d\'effectuer cette action.']);
        this.loading = false;
      }
    );
  }

}
