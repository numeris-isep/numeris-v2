import { Project } from "./project";
import { Address } from "./address";
import { Application } from "./application";

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

  applications_count: number;

  project: Project;
  address: Address;
  applications: Application[];

}
