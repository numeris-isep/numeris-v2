import { Component, ElementRef, Input, OnInit, ViewChild } from '@angular/core';
import Chart from 'chart.js';

@Component({
  selector: 'app-chart',
  templateUrl: './chart.component.html'
})
export class ChartComponent implements OnInit {

  @ViewChild('chartRef') chartRef: ElementRef;
  chart: Chart = [];

  @Input() configuration: any;

  constructor() { }

  ngOnInit() {
    this.generateCHart();
  }

  generateCHart() {
    this.chart = new Chart(this.chartRef.nativeElement.getContext('2d'), this.configuration);
  }

}
