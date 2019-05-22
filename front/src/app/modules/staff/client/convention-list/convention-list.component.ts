import { Component, Input, OnInit } from '@angular/core';
import { Client } from '../../../../core/classes/models/client';

@Component({
  selector: 'app-client-convention',
  templateUrl: './convention-list.component.html'
})
export class ConventionListComponent implements OnInit {

  @Input() client: Client;

  constructor() { }

  ngOnInit() {
  }

}
