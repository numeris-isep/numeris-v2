import { Component, OnInit } from '@angular/core';
import { ClientService } from "../../../../core/http/client.service";
import { Client } from "../../../../core/classes/models/client";
import { Contact } from "../../../../core/classes/models/contact";
import { ContactService } from "../../../../core/http/contact.service";
import { ActivatedRoute } from "@angular/router";

@Component({
  selector: 'app-client-index',
  templateUrl: './client-index.component.html'
})
export class ClientIndexComponent implements OnInit {

  clients: Client[];
  contacts: Contact[];

  contactTabActive: boolean = false;

  constructor(
    private clientService: ClientService,
    private contactService: ContactService,
    private route: ActivatedRoute,
  ) { }

  ngOnInit() {
    this.getClients();
    this.getContacts();

    this.route.data.subscribe(data => this.contactTabActive = data['tab'] === 'contacts');
  }


  getClients() {
    this.clientService.getClients().subscribe(clients => this.clients = clients);
  }

  getContacts() {
    this.contactService.getContacts().subscribe(contacts => this.contacts = contacts);
  }

}
