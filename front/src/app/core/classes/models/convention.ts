import { Client } from "./client";
import { Rate } from "./rate";

export class Convention {

  id: number;
  clientId: number;

  name: string;
  createdAt: string;
  updatedAt: string;

  client: Client;
  rates: Rate[];

}
