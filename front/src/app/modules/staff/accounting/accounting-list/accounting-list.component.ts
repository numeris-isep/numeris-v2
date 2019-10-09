import { Component, Input, OnInit } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import { Invoice } from '../../../../core/classes/models/Invoice';

@Component({
  selector: 'app-accounting-list',
  templateUrl: './accounting-list.component.html'
})
export class AccountingListComponent implements OnInit {

  @Input() statisticsByMonth: {
    month: string,
    payslips: Payslip[],
    invoices: Invoice[],
  }[];

  constructor() { }

  ngOnInit() {
  }

}
