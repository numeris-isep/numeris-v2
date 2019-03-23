import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-button-content',
  templateUrl: './button-content.component.html'
})
export class ButtonContentComponent implements OnInit {

  @Input() visibleIcon: string;
  @Input() hiddenIcon: string;

  constructor() { }

  ngOnInit() {
  }

}
