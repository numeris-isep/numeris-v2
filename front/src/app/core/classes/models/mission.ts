import { Project } from "./project";
import { Address } from "./address";
import { Application } from "./application";

export class Mission {

  id: number;
  projectId: number;
  addressId: number;

  isLocked: boolean;
  reference: string;
  title: string;
  description: string;
  startAt: string;
  duration: string;
  capacity: string;
  createdAt: string;
  updatedAt: string;

  applicationsCount: number;
  waitingApplicationsCount: number;
  acceptedApplicationsCount: number;
  refusedApplications: boolean;

  project: Project;
  address: Address;
  applications: Application[];

}
