import { Component, Input, OnInit } from '@angular/core';
import { Client } from '../../../../core/classes/models/client';

@Component({
  selector: 'app-client-list',
  templateUrl: './client-list.component.html'
})
export class ClientListComponent implements OnInit {

  @Input() clients: Client[];

  constructor() { }

  ngOnInit() {
  }

}
