import { Component, OnInit } from '@angular/core';
import { timer } from 'rxjs';

@Component({
  selector: 'app-wip',
  templateUrl: './wip.component.html'
})
export class WipComponent implements OnInit {

  value: number = 40;

  constructor() { }

  ngOnInit() {
    timer(2000, 2000).subscribe(() => {
      this.value = 25 + Math.random() * 74;
    });
  }

}
