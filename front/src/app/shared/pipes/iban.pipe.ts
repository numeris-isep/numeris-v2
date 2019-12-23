import { Pipe, PipeTransform } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';

@Pipe({
  name: 'iban'
})
export class IbanPipe implements PipeTransform {

  constructor(private sanitizer: DomSanitizer) {}

  transform(iban: string, withoutSpaceChar?: any): any {
    if (! iban) { return null; }

    const formatted = iban.toUpperCase().replace(/[^\dA-Z]/g, '');

    if (! withoutSpaceChar) {
      return formatted
        .replace(/(.{4})/g, '$1 ')
        .trim();
    }

    return this.sanitizer.bypassSecurityTrustHtml(
      formatted.replace(/(.{4})/g, '<span class="spaced">$1</span>')
    );
  }

}
