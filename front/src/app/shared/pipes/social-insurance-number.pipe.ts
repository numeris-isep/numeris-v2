import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'socialInsuranceNumber'
})
export class SocialInsuranceNumberPipe implements PipeTransform {

  transform(socialInsuranceNumber: string, args?: any): any {
    return socialInsuranceNumber.replace(/[^\d]/g, '')
      .replace(/(.)(.{0,2})(.{0,2})(.{0,2})(.{0,3})(.{0,3})(.{0,2})/, '$1 $2 $3 $4 $5 $6 $7')
      .trim();
  }

}
