import { Component, ElementRef, Input, OnInit, ViewChild } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import { Invoice } from '../../../../core/classes/models/Invoice';
import Chart from 'chart.js';
import * as moment from 'moment';
import { StatisticService } from '../../../../core/services/statistic.service';

@Component({
  selector: 'app-accounting-chart',
  templateUrl: './accounting-chart.component.html',
  styleUrls: ['./accounting-chart.component.css']
})
export class AccountingChartComponent implements OnInit {

  @ViewChild('chartRef') chartRef: ElementRef;

  @Input() year;
  @Input() statisticsByMonth: {
    month: string,
    payslips: Payslip[],
    invoices: Invoice[],
  }[];

  chart: Chart = [];

  constructor(private statisticService: StatisticService) { }

  ngOnInit() {
    this.generateChart();
  }

  get options() {
    return {
      type: 'line',
      data: {
        labels: this.monthNames,
        datasets: [
          {
            label: 'Salaires bruts',
            borderColor: '#767676',
            fill: false,
            data: this.payslipGrossAmounts,
          },
          {
            label: 'Coût des prestations',
            borderColor: '#FBBD08',
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

  generateChart() {
    this.chart = new Chart(this.chartRef.nativeElement.getContext('2d'), this.options);
  }

}
