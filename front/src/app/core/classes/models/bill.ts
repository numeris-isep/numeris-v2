import { Application } from './application';
import { Rate } from './rate';

export class Bill {

  id: number;
  applicationId: number;
  rateId: number;

  application: Application;
  rate: Rate;
  amount: number;

}
