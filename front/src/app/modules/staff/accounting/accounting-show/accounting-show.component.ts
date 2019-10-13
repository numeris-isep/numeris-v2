import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import * as moment from 'moment';
import { Moment } from 'moment';
import { forkJoin, Observable } from 'rxjs';
import { Payslip } from '../../../../core/classes/models/payslip';
import { Invoice } from '../../../../core/classes/models/Invoice';
import { PayslipService } from '../../../../core/http/payslip.service';
import { InvoiceService } from '../../../../core/http/invoice.service';

@Component({
  selector: 'app-accounting-show',
  templateUrl: './accounting-show.component.html',
  styleUrls: ['./accounting-show.component.css'],
})
export class AccountingShowComponent implements OnInit {

  month: Moment;
  payslips: Payslip[];
  invoices: Invoice[];
  statisticByMonth: {
    month: string,
    payslips: Payslip[],
    invoices: Invoice[],
  };

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private payslipService: PayslipService,
    private invoiceService: InvoiceService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService,
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.month = moment(`${param.year}-${param.month}-01 00:00:00`);

      if (! this.month.isValid()) {
        this.router.navigate(['/comptabilite']);
        return;
      }

      this.getData();
    });
  }

  getData() {
    forkJoin([this.getPayslips(), this.getInvoices()]).subscribe(data => {
      this.setTitlesAndBreadcrumbs();

      const month = this.month.format('Y-MM-DD HH:mm:ss');
      [this.payslips, this.invoices] = [
        data[0].filter(payslip => payslip.month === month),
        data[1].filter(invoice => invoice.project.startAt === month),
      ];
      this.statisticByMonth = {
        month: month,
        payslips: this.payslips,
        invoices: this.invoices,
      };
    });
  }

  getPayslips(): Observable<Payslip[]> {
    return this.payslipService.getPayslips(this.month.get('year').toString());
  }

  getInvoices(): Observable<Invoice[]> {
    return this.invoiceService.getInvoices(this.month.get('year').toString());
  }

  setTitlesAndBreadcrumbs () {
    const year: string = this.month.get('year').toString();
    const month: string = (this.month.get('month') + 1).toString();
    const formattedMonth: string = this.month.locale('fr').format('MMMM Y');

    this.titleService.setTitles(
      `Comptabilité - ${formattedMonth.charAt(0).toUpperCase() + formattedMonth.slice(1)}`
    );
    this.breadcrumbsService.addBreadcrumb(
      [
        {title: `Comptabilité`, url: `/comptabilite`},
        {title: year, url: `/comptabilite/${year}`},
        {title: ('0' + month).slice(-2), url: ''},
      ]
    );
  }

}
