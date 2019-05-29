import { Component, OnInit } from '@angular/core';
import { Convention } from '../../../../core/classes/models/convention';
import { ComponentModalConfig, ModalSize, SuiModal } from 'ng2-semantic-ui';
import { AlertService } from '../../../../core/services/alert.service';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { ConventionService } from '../../../../core/http/convention.service';
import { Client } from '../../../../core/classes/models/client';

export interface IConventionDeleteContext {
  title: string;
  question: string;
  convention: Convention;
  client: Client;
}

@Component({
  selector: 'app-convention-delete-modal',
  templateUrl: './convention-delete-modal.component.html'
})
export class ConventionDeleteModalComponent implements OnInit {

  convention: Convention = this.modal.context.convention;
  client: Client = this.modal.context.client;

  loading: boolean = false;

  constructor(
    public modal: SuiModal<IConventionDeleteContext, void>,
    private conventionService: ConventionService,
    private alertService: AlertService,
    private router: Router
  ) { }

  ngOnInit() {
  }

  onClick() {
    this.loading = true;

    this.deleteConvention().subscribe(
      () => {
        this.router.navigate([`/clients/${this.client.id}/conventions`]);
        this.alertService.success([`Le convention ${this.convention.name} a bien été supprimée.`]);
        this.modal.approve(undefined);
      },
      error => this.modal.deny(undefined)
    );
  }

  deleteConvention(): Observable<Convention> {
    return this.conventionService.deleteConvention(this.convention);
  }

}

export class ConventionDeleteModal extends ComponentModalConfig<IConventionDeleteContext, void> {

  constructor(
    title: string,
    question: string,
    convention: Convention,
    client: Client,
    size = ModalSize.Small,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(ConventionDeleteModalComponent, { title, question, convention, client });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }

}
