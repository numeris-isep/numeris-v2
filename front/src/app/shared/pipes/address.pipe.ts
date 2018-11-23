import { Pipe, PipeTransform } from '@angular/core';
import { Address } from "../../core/classes/models/address";

@Pipe({
  name: 'address'
})
export class AddressPipe implements PipeTransform {

  transform(address: Address, args?: any): string {
    return `${address.street}, ${address.zipCode}, ${address.city}`;
  }

}
