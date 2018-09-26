import { Component, OnInit } from '@angular/core';
import { SuiModal, ComponentModalConfig, ModalSize } from "ng2-semantic-ui"

export interface IConfirmModalContext {
  title: string;
  question: string;
}

@Component({
  selector: 'confirm-modal',
  templateUrl: './confirm-modal.component.html'
})
export class ConfirmModalComponent implements OnInit {

  constructor(public modal: SuiModal<IConfirmModalContext, void, void>) { }

  ngOnInit() {
  }
}

export class ConfirmModal extends ComponentModalConfig<IConfirmModalContext, void, void> {

  constructor(
    title: string,
    question: string,
    size = ModalSize.Small,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(ConfirmModalComponent, { title, question });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }
}
