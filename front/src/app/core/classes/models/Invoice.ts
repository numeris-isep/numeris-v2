import { Project } from './project';

export class Invoice {

  id: number;
  project: Project;
  grossAmount: number;
  vatAmount: number;
  finalAmount: number;
  details: {
    title: string,
    startAt: string,
    reference: string,
    bills: {
      rate: string,
      hours: number,
      amount: number,
      total: number,
    }[]
  }[];
  createdAt: string;
  updatedAt: string;

}
