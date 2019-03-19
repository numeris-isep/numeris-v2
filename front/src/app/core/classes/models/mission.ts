import { Project } from "./project";
import { Address } from "./address";

export class Mission {

  id: number;
  projectId: number;
  addressId: number;

  isLocked: boolean;
  title: string;
  description: string;
  startAt: string;
  duration: string;
  capacity: string;
  createdAt: string;
  updatedAt: string;

  project: Project;
  address: Address;

}
