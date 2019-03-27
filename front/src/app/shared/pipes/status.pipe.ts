import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'status'
})
export class StatusPipe implements PipeTransform {

  stepTranslations = {
    hiring: 'Ouvert',
    validated: 'Validé',
    billed: 'Facturé',
    paid: 'Payé',
    closed: 'Cloturé'
  };

  transform(status: string, args?: any): any {
    return this.stepTranslations[status];
  }

}
