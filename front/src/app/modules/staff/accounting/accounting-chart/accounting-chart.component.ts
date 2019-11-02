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
      type: 'bar',
      data: {
        labels: this.monthNames,
        datasets: [
          {
            label: 'Salaires bruts',
            borderColor: '#767676',
            backgroundColor: '#767676',
            fill: false,
            yAxisID: 'A',
            data: this.payslipGrossAmounts,
          },
          {
            label: 'Coût des prestations',
            borderColor: '#FBBD08',
            backgroundColor: '#FBBD08',
            fill: false,
            yAxisID: 'A',
            data: this.invoiceFinalAmounts,
          },
          {
            label: 'Nombre d\'étudiants',
            borderColor: '#7CC7FF',
            backgroundColor: '#7CC7FF',
            fill: false,
            yAxisID: 'B',
            data: this.studentCount,
          },
        ]
      },
      options: {
        scales: {
          yAxes: [
            {
              id: 'A',
              type: 'linear',
              position: 'left',
              ticks: {
                beginAtZero: true
              },
            },
            {
              id: 'B',
              type: 'linear',
              position: 'right',
              ticks: {
                beginAtZero: true
              },
            },
          ]
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

  get studentCount() {
    return this.statisticsByMonth.map(stat => stat.payslips.length);
  }

  get invoiceFinalAmounts() {
    return this.statisticsByMonth.map(stat => (
      this.statisticService
        .calculateInvoiceAmounts(stat.invoices)
        .finalAmounts.toFixed(2)
      )
    );
  }

}
