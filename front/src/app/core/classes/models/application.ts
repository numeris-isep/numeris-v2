import { User } from "./user";
import { Mission } from "./mission";
import { Bill } from './bill';

export class Application {

  id: number;
  userId: number;
  missionId: number;

  type: string;
  status: string;
  createdAt: string;
  updatedAt: string;

  user: User;
  mission: Mission;
  bills: Bill[];

}

export class ApplicationStatus {

  status: string;
  translation: string;
  translationPlural: string;

}
