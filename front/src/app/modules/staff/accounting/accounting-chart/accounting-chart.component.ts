import { Component, Input, OnInit } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import { Invoice } from '../../../../core/classes/models/Invoice';
import * as moment from 'moment';
import { StatisticService } from '../../../../core/services/statistic.service';

@Component({
  selector: 'app-accounting-chart',
  templateUrl: './accounting-chart.component.html'
})
export class AccountingChartComponent implements OnInit {

  @Input() year;
  @Input() statisticsByMonth: {
    month: string,
    payslips: Payslip[],
    invoices: Invoice[],
  }[];

  configuration: any;

  constructor(private statisticService: StatisticService) { }

  ngOnInit() {
    this.configure();
  }

  configure() {
    this.configuration = {
      type: 'line',
      data: {
        labels: this.monthNames,
        datasets: [
          {
            label: 'Salaires bruts',
            borderColor: '#767676',
            backgroundColor: '#767676',
            fill: false,
            data: this.payslipGrossAmounts,
          },
          {
            label: 'Coût des prestations',
            borderColor: '#FBBD08',
            backgroundColor: '#FBBD08',
            fill: false,
            data: this.invoiceFinalAmounts,
          },
        ]
      },
      options: {
        title: {
          display: true,
          text: this.title,
        },
      }
    };
  }

  get monthNames() {
    return this.statisticsByMonth.map(stat => {
      const monthName = moment(stat.month).locale('fr-FR')
        .format('MMMM');

      return monthName.charAt(0).toUpperCase() + monthName.slice(1);
      }
    );
  }

  get payslipGrossAmounts() {
    return this.statisticsByMonth.map(stat => (
      this.statisticService
        .calculatePayslipAmounts(stat.payslips)
        .grossAmounts.toFixed(2)
      )
    );
  }

  get invoiceFinalAmounts() {
    return this.statisticsByMonth.map(stat => (
      this.statisticService
        .calculateInvoiceAmounts(stat.invoices)
        .finalAmounts.toFixed(2)
      )
    );
  }

  get title() {
    return `Salaires bruts et coût des prestations en ${moment(this.year)}`;
  }

}
