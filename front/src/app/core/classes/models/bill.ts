import { Application } from './application';

export class Bill {

  id: number;
  billId: number;
  applicationId: number;

  bill: Bill;
  application: Application;
  amount: number;

}
