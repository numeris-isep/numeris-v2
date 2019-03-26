import { Component, OnInit } from '@angular/core';
import { Client } from "../../../core/classes/models/client";
import { ClientService } from "../../../core/http/client.service";

@Component({
  selector: 'app-client',
  templateUrl: './client.component.html'
})
export class ClientComponent implements OnInit {

  clients: Client[];

  constructor(private clientService: ClientService) { }

  ngOnInit() {
    this.getClients();
  }

  getClients() {
    this.clientService.getClients().subscribe(clients => this.clients = clients);
  }

}
