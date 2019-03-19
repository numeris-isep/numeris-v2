import { Client } from "./client";
import { Convention } from "./convention";

export class Project {

  id: number;
  clientId: number;
  conventionId: number;

  name: string;
  step: string;
  start_at: string;
  isPrivate: boolean;
  moneyReceivedAt: string;
  createdAt: string;
  updatedAt: string;

  client: Client;
  convention: Convention;

}
