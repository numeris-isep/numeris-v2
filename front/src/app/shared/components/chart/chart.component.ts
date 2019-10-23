import { Component, ElementRef, Input, OnChanges, OnInit, SimpleChanges, ViewChild } from '@angular/core';
import Chart from 'chart.js';

@Component({
  selector: 'app-chart',
  templateUrl: './chart.component.html'
})
export class ChartComponent implements OnInit, OnChanges {

  @ViewChild('chartRef') chartRef: ElementRef;
  chart: Chart = [];

  @Input() configuration: any;

  constructor() { }

  ngOnInit() {
    this.generateCHart();
  }

  ngOnChanges(simpleChanges: SimpleChanges) {
    const changes = simpleChanges.configuration;

    if (! changes.firstChange) {
      this.configuration = changes.currentValue;
      this.generateCHart();
    }
  }

  generateCHart() {
    this.chart = new Chart(this.chartRef.nativeElement.getContext('2d'), this.configuration);
  }

}
