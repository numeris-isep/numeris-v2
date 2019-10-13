import { Component, Input, OnInit } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import { Invoice } from '../../../../core/classes/models/Invoice';

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

  constructor() { }

  ngOnInit() {
  }

}
