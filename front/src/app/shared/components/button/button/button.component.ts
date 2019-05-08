import { Component, Input, OnChanges, OnInit } from '@angular/core';
import { Button } from "../button";

@Component({
  selector: 'app-button',
  templateUrl: './button.component.html'
})
export class ButtonComponent
  extends Button
  implements OnInit, OnChanges {

  @Input() isLoading: boolean = false;
  @Input() isDisabled: boolean = false;

  constructor() {
    super();
  }

  ngOnInit() {
    this.animation = this.hiddenIcon != undefined ? 'fade animated' : '';

    this.classes = [
      this.color, this.size, this.animation, this.attachment, this.behaviour,
    ];
  }

  ngOnChanges() {
    this.ngOnInit();
  }
}
