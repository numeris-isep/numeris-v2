import { Mission } from './mission';
import { Client } from './client';

export class Payslip {

  id: number;
  month: string;
  grossAmount: number;
  netAmount: number;
  finalAmount: number;
  subscriptionFee: number;
  deductionAmount: number;
  employerDeductionAmount: number;
  deductions: {
    base: number,
    employeeAmount: number,
    employerAmount: number,
    socialContribution: string
  }[];
  operations: Mission[];
  clients: Client[];

}
