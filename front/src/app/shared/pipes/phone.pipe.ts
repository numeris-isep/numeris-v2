import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'phone'
})
export class PhonePipe implements PipeTransform {

  transform(phone: string, args?: any): string {

    const separator: string = "\xa0";
    let result: string = "";

    for (let i = 0; i < phone.length; i += 2) {
      result += phone.substr(i, 2) + (i != 8 ? separator : "");
    }

    return result;
  }

}
