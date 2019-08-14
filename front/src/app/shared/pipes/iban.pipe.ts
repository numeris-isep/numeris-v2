import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'iban'
})
export class IbanPipe implements PipeTransform {

  transform(iban: string, args?: any): any {
    if (iban) {
      return iban.toUpperCase().replace(/[^\dA-Z]/g, '')
        .replace(/(.{4})/g, '$1 ')
        .trim();
    }

    return null;
  }

}
