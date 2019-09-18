import { Mission } from './mission';
import { Client } from './client';

export class Payslip {

  id: number;
  month: string;
  hourAmount: number;
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
  createdAt: string;
  updatedAt: string;

}
