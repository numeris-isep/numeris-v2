import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'hours'
})
export class HoursPipe implements PipeTransform {

  transform(hours: any, args?: any): any {
    if (hours) {
      const min = (hours * 60) % 60;
      return Math.floor(hours) + 'h' + (min === 0 ? '' : min);
    }

    return null;
  }

}
