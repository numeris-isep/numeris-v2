import { Component, OnInit } from '@angular/core';
import { ApplicationService } from '../../../../core/http/application.service';
import { Moment } from 'moment';
import * as moment from 'moment';
import { TitleCasePipe } from '@angular/common';

@Component({
  selector: 'app-application-chart',
  templateUrl: './application-chart.component.html'
})
export class ApplicationChartComponent implements OnInit {

  selectedYear: Moment = moment();
  monthNames: string[] = [];
  data: number[] = [];

  configuration: any;

  constructor(
    private applicationService: ApplicationService,
    private titlecasePipe: TitleCasePipe,
  ) { }

  ngOnInit() {
    this.getData();
  }

  configure() {
    this.configuration = {
      type: 'line',
      data: {
        labels: this.monthNames,
        datasets: [
          {
            label: 'Candidatures',
            borderColor: '#A5673F',
            backgroundColor: '#A5673F',
            fill: false,
            data: this.data,
          },
        ]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        },
      }
    };
  }

  getData() {
    this.reset();

    this.applicationService.getApplications(this.selectedYear.get('year').toString()).subscribe(applications => {
      for (let i = 0; i <= 11; i ++) {
        const month = moment({M: i, y: this.selectedYear.year()});

        this.monthNames.push(this.titlecasePipe.transform(month.locale('fr-FR').format('MMMM')));
        this.data.push(applications.filter(application => (
          moment(application.createdAt).isBetween(month, month.clone().add(1, 'month'))
        )).length);
      }

      this.configure();
    });
  }

  changeYear(operation: string) {
    this.selectedYear[operation](1, 'year');
    this.getData();
  }

  reset() {
    this.monthNames = [];
    this.data = [];
  }

}
