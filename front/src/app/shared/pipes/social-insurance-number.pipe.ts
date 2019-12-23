import { Pipe, PipeTransform } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';

@Pipe({
  name: 'socialInsuranceNumber'
})
export class SocialInsuranceNumberPipe implements PipeTransform {

  constructor(private sanitizer: DomSanitizer) {}

  transform(socialInsuranceNumber: string, withoutSpaceChar?: any): any {
    if (! socialInsuranceNumber) { return null; }

    const formatted = socialInsuranceNumber.replace(/[^\d]/g, '');

    if (! withoutSpaceChar) {
      return formatted
        .replace(/(.)(.{0,2})(.{0,2})(.{0,2})(.{0,3})(.{0,3})(.{0,2})/, '$1 $2 $3 $4 $5 $6 $7')
        .trim();
    }

    return this.sanitizer.bypassSecurityTrustHtml(formatted.replace(
      /(.)(.{0,2})(.{0,2})(.{0,2})(.{0,3})(.{0,3})(.{0,2})/,
      '<span class="spaced">$1</span>' +
      '<span class="spaced">$2</span>' +
      '<span class="spaced">$3</span>' +
      '<span class="spaced">$4</span>' +
      '<span class="spaced">$5</span>' +
      '<span class="spaced">$6</span>' +
      '<span class="spaced">$7</span>')
    );
  }

}
