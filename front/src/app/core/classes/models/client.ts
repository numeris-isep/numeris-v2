import { Address } from "./address";

export class Client {

  id: number;
  addressId: number;

  name: string;
  reference: string;
  createdAt: string;
  updatedAt: string;

  conventionsCount: number = null;
  projectsCount: number = null;
  missionsCount: number = null;

  address: Address;

}
