import { Address } from './address';
import { Preference } from './preference';
import { Role } from './role';

export class User {

  id: number;
  preferenceId: number;
  addressId: number;

  activated: boolean;
  touAccepted: boolean;
  subscriptionPaidAt: boolean;
  email: string;
  password: string;
  username: string;
  firstName: string;
  lastName: string;
  promotion: string;
  phone: string;
  nationality: string;
  birthDate: string;
  birth_date: string;
  birthCity: string;
  socialInsuranceNumber: string;
  social_insurance_number: string;
  iban: string;
  bic: string;
  createdAt: string;
  updatedAt: string;

  address: Address;
  preference: Preference;
  roles: Role[];
}
