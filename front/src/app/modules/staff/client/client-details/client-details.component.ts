import { Component, OnInit, Input } from '@angular/core';
import { Client } from '../../../../core/classes/models/client';
import { ClientDeleteModal } from '../client-delete-modal/client-delete-modal.component';
import { SuiModalService } from 'ng2-semantic-ui';

@Component({
  selector: 'app-client-details',
  templateUrl: './client-details.component.html',
  styleUrls: ['./client-details.component.css']
})
export class ClientDetailsComponent implements OnInit {

  @Input() client: Client;
  @Input() isLink: boolean = false;

  private deleteModal: ClientDeleteModal;

  constructor(private modalService: SuiModalService) { }

  ngOnInit() {
    this.deleteModal = new ClientDeleteModal(
      this.client.name,
      `Voulez-vous vraiment supprimer le client ${this.client.name} ?`,
      this.client
    );
  }

  openModal() {
    this.modalService.open(this.deleteModal);
  }

}
