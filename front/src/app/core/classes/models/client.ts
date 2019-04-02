import { Address } from "./address";
import { Convention } from "./convention";
import { Project } from "./project";
import { Mission } from "./mission";

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
  conventions: Convention[];
  projects: Project[];
  missions: Mission[];

}
