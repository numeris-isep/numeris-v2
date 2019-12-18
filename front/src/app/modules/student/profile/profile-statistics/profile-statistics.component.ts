import { Component, Input, OnInit } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';
import { PayslipAmount } from '../../../../core/classes/payslip-amount';
import { StatisticService } from '../../../../core/services/statistic.service';

@Component({
  selector: 'app-profile-statistics',
  templateUrl: './profile-statistics.component.html'
})
export class ProfileStatisticsComponent implements OnInit {

  @Input() payslips: Payslip[];

  payslipAmounts: PayslipAmount;
  missionAmounts: number = 0;

  finalCount: any;
  hourCount: any;
  missionCount: any;

  constructor(private statisticService: StatisticService) { }

  ngOnInit() {
    this.calculate();
  }

  calculate() {
    this.payslipAmounts = this.statisticService.calculatePayslipAmounts(this.payslips);
    this.payslips.forEach(payslip => this.missionAmounts += payslip.operations.length);
  }

}
