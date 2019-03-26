import { Component, OnInit, Input } from '@angular/core';
import { Client } from "../../../../core/classes/models/client";

@Component({
  selector: 'app-client-details',
  templateUrl: './client-details.component.html',
  styleUrls: ['./client-details.component.css']
})
export class ClientDetailsComponent implements OnInit {

  @Input() client: Client;

  constructor() { }

  ngOnInit() {
  }

}
