import { Component, OnInit } from '@angular/core';
import * as moment from 'moment';
import { Payslip } from '../../../../core/classes/models/payslip';
import { PayslipService } from '../../../../core/http/payslip.service';
import { ActivatedRoute, Router } from '@angular/router';
import { TitleService } from '../../../../core/services/title.service';
import { BreadcrumbsService } from '../../../../core/services/breadcrumbs.service';
import { Invoice } from '../../../../core/classes/models/Invoice';
import { InvoiceService } from '../../../../core/http/invoice.service';
import { forkJoin, Observable } from 'rxjs';

@Component({
  selector: 'app-accounting-index',
  templateUrl: './accounting-index.component.html'
})
export class AccountingIndexComponent implements OnInit {

  loading: boolean = false;
  selectedYear: number = moment().get('year');
  years: number[] = [];

  payslips: Payslip[];
  invoices: Invoice[];
  statisticsByMonth: {
    month: string,
    payslips: Payslip[],
    invoices: Invoice[],
  }[];

  constructor(
    private route: ActivatedRoute,
    private payslipService: PayslipService,
    private invoiceService: InvoiceService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.initYears();

    this.route.params.subscribe(param => {
      this.selectedYear = parseInt(param.year);

      if (! (this.years.filter(y => y === parseInt(param.year)).length > 0)) {
        const currentYear: number = moment().get('year');
        this.router.navigate([`/comptabilite/${currentYear}`]);
        this.selectedYear = currentYear;
      }

      this.selectYear();
    });
  }

  initYears() {
    for (let i = 2019; i <= moment().get('year'); i++) {
      this.years.push(i);
    }
  }

  selectYear() {
    this.loading = true;

    forkJoin([this.getPayslips(), this.getInvoices()]).subscribe(data => {
      [this.payslips, this.invoices] = data;

      this.initStatisticsByMonth();
      this.setTitlesAndBreadcrumbs();
      this.loading = false;
    });
  }

  getPayslips(): Observable<Payslip[]> {
    return this.payslipService.getPayslips(this.selectedYear.toString());
  }

  getInvoices(): Observable<Invoice[]> {
    return this.invoiceService.getInvoices(this.selectedYear.toString());
  }

  initStatisticsByMonth() {
    this.statisticsByMonth = [];

    for (let i = 1; i <= 12; i++) {
      const month = `${this.selectedYear}-${('0' + i).slice(-2)}-01 00:00:00`;

      this.statisticsByMonth.push({
        month: month,
        payslips: this.payslips.filter(payslip => payslip.month === month),
        invoices: this.invoices.filter(invoice => invoice.project.startAt === month),
      });
    }
  }

  setTitlesAndBreadcrumbs () {
    this.titleService.setTitles(`Comptabilité - ${this.selectedYear}`);
    this.breadcrumbsService.addBreadcrumb(
      [
        {title: `Comptabilité`, url: `/comptabilite`},
        {title: this.selectedYear.toString(), url: `/comptabilite/${this.selectedYear}`},
      ]
    );
  }

}
