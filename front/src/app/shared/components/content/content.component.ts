import { Component, Input, OnInit } from '@angular/core';
import { Transition, TransitionController, TransitionDirection } from "ng2-semantic-ui";

@Component({
  selector: 'app-content',
  templateUrl: './content.component.html',
  styleUrls: ['./content.component.css']
})
export class ContentComponent implements OnInit {

  public transitionController = new TransitionController();
  @Input() condition: boolean = true;

  constructor() { }

  ngOnInit() {
    this.animate();
  }

  public animate(transitionName:string = "fade") {
    this.transitionController.animate(
      new Transition(transitionName, 500, TransitionDirection.In)
    );
  }
}
