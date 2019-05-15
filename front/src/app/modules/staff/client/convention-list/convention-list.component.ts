import { Component, Input, OnInit } from '@angular/core';
import { Convention } from '../../../../core/classes/models/convention';

@Component({
  selector: 'app-client-convention',
  templateUrl: './convention-list.component.html'
})
export class ConventionListComponent implements OnInit {

  @Input() conventions: Convention[];

  constructor() { }

  ngOnInit() {
  }

}
