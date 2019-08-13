import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'phone'
})
export class PhonePipe implements PipeTransform {

  transform(phone: string, args?: any): string {
    return phone.replace(/[^\d]/g, '')
      .replace(/(.{2})/g, '$1 ')
      .trim();
  }

}
