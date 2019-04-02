import { Component, OnInit } from '@angular/core';
import { ClientService } from "../../../../core/http/client.service";
import { Client } from "../../../../core/classes/models/client";

@Component({
  selector: 'app-client-index',
  templateUrl: './client-index.component.html'
})
export class ClientIndexComponent implements OnInit {

  clients: Client[];

  constructor(private clientService: ClientService) { }

  ngOnInit() {
    this.getClients();
  }

  getClients() {
    this.clientService.getClients().subscribe(clients => this.clients = clients);
  }

}
