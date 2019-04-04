import { Component, Input, OnInit } from '@angular/core';
import { Button } from "../button";

@Component({
  selector: 'app-link-button',
  templateUrl: './link-button.component.html'
})
export class LinkButtonComponent
  extends Button
  implements OnInit {

  @Input() routerLink: string = '#';

  constructor() {
    super();
  }

  ngOnInit() {
    this.animation = this.hiddenIcon != undefined ? 'fade animated' : '';

    this.classes = [
      this.color, this.size, this.animation, this.attachment, this.behaviour
    ];
  }

}
