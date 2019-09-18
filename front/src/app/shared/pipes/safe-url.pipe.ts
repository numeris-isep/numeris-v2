import { Pipe, PipeTransform } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';

@Pipe({
  name: 'safeURL'
})
export class SafeURLPipe implements PipeTransform {

  constructor(private sanitizer: DomSanitizer) {}

  transform(url: any, args?: any): any {
    if (url) {
      return this.sanitizer.bypassSecurityTrustResourceUrl(url);
    }

    return null;
  }

}
