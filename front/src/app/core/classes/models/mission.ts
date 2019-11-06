import { Project } from './project';
import { Address } from './address';
import { Application } from './application';
import { User } from './user';
import { Contact } from './contact';

export class Mission {

  id: number;

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
  user: User;
  contact: Contact;
  address: Address;
  applications: Application[];

}
