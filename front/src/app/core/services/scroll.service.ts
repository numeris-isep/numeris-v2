import { Injectable } from '@angular/core';
import { Router } from "@angular/router";

@Injectable({
  providedIn: 'root'
})
export class ScrollService {

  private elements: any;

  constructor(
    private router: Router
  ) { }

  setPageElements(elements: any) {
    this.elements = elements;
  }

  scrollToElement(anchor: string): any {
    if (this.elements == undefined) {
      this.router.navigate(['/']);
      return;
    }

    return this.elements[anchor] == undefined ? null
      : this.elements[anchor]
        .nativeElement
        .scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}