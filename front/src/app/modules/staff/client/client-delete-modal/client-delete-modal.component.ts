import { Component, OnInit } from '@angular/core';
import { SuiModal, ComponentModalConfig, ModalSize } from "ng2-semantic-ui";
import { Client } from "../../../../core/classes/models/client";
import { ClientService } from "../../../../core/http/client.service";
import { AlertService } from "../../../../core/services/alert.service";
import { Router } from "@angular/router";
import { Observable } from "rxjs";

export interface IClientDeleteModalContext {
  title: string;
  question: string;
  client: Client;
}

@Component({
  selector: 'app-client-delete-modal',
  templateUrl: './client-delete-modal.component.html',
  styleUrls: ['./client-delete-modal.component.css']
})
export class ClientDeleteModalComponent implements OnInit {

  client: Client = this.modal.context.client;

  loading: boolean = false;

  constructor(
    public modal: SuiModal<IClientDeleteModalContext, void>,
    private clientService: ClientService,
    private alertService: AlertService,
    private router: Router
  ) { }

  ngOnInit() {
  }

  onClick() {
    this.loading = true;

    this.deleteClient().subscribe(() => {
      this.alertService.success([`Le client ${this.client.name} a bien été supprimé.`], null, true);
      this.router.navigate(['/clients']);
      this.modal.approve(undefined);
    });
  }

  deleteClient(): Observable<Client> {
    return this.clientService.deleteClient(this.client);
  }

}

export class ClientDeleteModal extends ComponentModalConfig<IClientDeleteModalContext, void> {

  constructor(
    title: string,
    question: string,
    client: Client,
    size = ModalSize.Small,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(ClientDeleteModalComponent, { title, question, client });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }

}
