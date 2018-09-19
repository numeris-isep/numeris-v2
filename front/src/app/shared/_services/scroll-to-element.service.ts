import { ElementRef, Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ScrollToElementService {

  private elements: ElementRef[];

  constructor() { }

  setPageElements(elements: ElementRef[]) {
    this.elements = elements;
  }

  scrollToElement(id: number) {
    this.elements[id]
      .nativeElement
      .scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}
