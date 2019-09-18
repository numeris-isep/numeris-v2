import { Address } from './address';
import { Convention } from './convention';
import { Project } from './project';
import { Mission } from './mission';
import { Contact } from './contact';
import { Invoice } from './Invoice';

export class Client {

  id: number;
  addressId: number;
  contactId: number;

  name: string;
  createdAt: string;
  updatedAt: string;

  conventionsCount: number = null;
  projectsCount: number = null;
  missionsCount: number = null;

  address: Address;
  contact: Contact;
  conventions: Convention[];
  projects: Project[];
  missions: Mission[];
  invoices: Invoice[];

}
