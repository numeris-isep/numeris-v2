import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-button-content',
  templateUrl: './button-content.component.html'
})
export class ButtonContentComponent implements OnInit {

  @Input() visibleContent: string;
  @Input() visibleIcon: string;
  @Input() hiddenIcon: string;

  constructor() { }

  ngOnInit() {
  }

}
