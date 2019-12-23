import { Pipe, PipeTransform } from '@angular/core';
import { dateToISO } from '../utils';

@Pipe({
  name: 'dateToISO'
})
export class DateToIsoPipe implements PipeTransform {

  transform(date: string): any {
    return dateToISO(date);
  }

}
