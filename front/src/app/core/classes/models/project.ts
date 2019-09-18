import { Client } from "./client";
import { Convention } from "./convention";
import { Invoice } from './Invoice';

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
  usersCount: number;

  client: Client;
  convention: Convention;
  invoice: Invoice;

}

export class ProjectStep {

  step: string;
  translation: string;

}
