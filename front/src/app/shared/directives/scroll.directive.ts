import { Directive, EventEmitter, HostListener, Output } from '@angular/core';

@Directive({
  selector: '[appScroll]'
})
export class ScrollDirective {

  @Output() scrollPosition: EventEmitter<number> = new EventEmitter<number>();
  position: number;

  constructor() { }

  @HostListener('scroll', ['$event'])
  scroll(event: Event) {
    this.scrollPosition.emit(event.srcElement.scrollTop);
  }

}
