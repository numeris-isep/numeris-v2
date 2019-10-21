import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ScrollService {

  scrollPosition: BehaviorSubject<number> = new BehaviorSubject<number>(0);
  private elements: any;

  constructor(
    private router: Router
  ) { }

  setScrollPosition(y: number) {
    this.scrollPosition.next(y);
  }

  setPageElements(elements: any) {
    this.elements = elements;
  }

  scrollToElement(anchor: string): any {
    if (this.elements === undefined) {
      this.router.navigate(['/']);
      return;
    }

    return this.elements[anchor] === undefined ? null
      : this.elements[anchor]
        .nativeElement
        .scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}
