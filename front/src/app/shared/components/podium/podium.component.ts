import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-podium',
  templateUrl: './podium.component.html',
  styleUrls: ['./podium.component.css']
})
export class PodiumComponent implements OnInit {

  currentMonth: string = 'Septembre';
  currentYear: string = '2018';

  constructor() { }

  ngOnInit() {
  }

}
