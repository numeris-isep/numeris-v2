import { User } from "./user";
import { Mission } from "./mission";

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

}
