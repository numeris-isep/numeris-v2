import { Client } from "./client";
import { Convention } from "./convention";

export class Project {

  id: number;
  clientId: number;
  conventionId: number;

  name: string;
  step: string;
  startAt: string;
  isPrivate: boolean;
  moneyReceivedAt: string;
  createdAt: string;
  updatedAt: string;

  missionsCount: number;

  client: Client;
  convention: Convention;

}
