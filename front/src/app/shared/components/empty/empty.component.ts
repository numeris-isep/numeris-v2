import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-empty',
  templateUrl: './empty.component.html'
})
export class EmptyComponent implements OnInit {

  @Input() icon: boolean = true;

  constructor() { }

  ngOnInit() {
  }

}
