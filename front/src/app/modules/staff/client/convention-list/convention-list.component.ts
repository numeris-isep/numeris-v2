import { Component, Input, OnInit } from '@angular/core';
import { Client } from '../../../../core/classes/models/client';
import { Convention } from '../../../../core/classes/models/convention';
import { ConventionDeleteModal } from '../convention-delete-modal/convention-delete-modal.component';
import { SuiModalService } from 'ng2-semantic-ui';

@Component({
  selector: 'app-client-convention',
  templateUrl: './convention-list.component.html'
})
export class ConventionListComponent implements OnInit {

  @Input() client: Client;
  deleteModal: ConventionDeleteModal;

  constructor(private modalService: SuiModalService) { }

  ngOnInit() {
  }

  openModal(convention: Convention) {
    this.deleteModal = new ConventionDeleteModal(
      convention.name,
      `Voulez-vous vraiment supprimer la convention ${convention.name} ?`,
      convention,
      this.client
    );

    this.modalService.open(this.deleteModal);
  }

}
