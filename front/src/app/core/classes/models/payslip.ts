import { Mission } from './mission';
import { Client } from './client';
import { User } from './user';

export class Payslip {

  id: number;
  user: User;
  signed: boolean;
  paid: boolean;
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
