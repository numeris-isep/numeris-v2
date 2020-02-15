import { Component, OnInit } from '@angular/core';
import { ComponentModalConfig, ModalSize } from 'ng2-semantic-ui';
import { SuiModal } from 'ng2-semantic-ui';

export interface IPreviewModalContext {
  assetPath: string;
  assetTitle: string;
}

@Component({
  selector: 'app-preview-modal',
  templateUrl: './preview-modal.component.html',
})
export class PreviewModalComponent implements OnInit {

  assetPath: string = this.previewModal.context.assetPath;
  assetTitle: string = this.previewModal.context.assetTitle;

  constructor(
    public previewModal: SuiModal<IPreviewModalContext, void, void>,
  ) { }

  ngOnInit() {
  }

}

export class PreviewModal extends ComponentModalConfig<IPreviewModalContext, void, void> {

  constructor(
    assetPath,
    assetTitle,
    size = ModalSize.Large,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(PreviewModalComponent, { assetPath, assetTitle });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }

}
