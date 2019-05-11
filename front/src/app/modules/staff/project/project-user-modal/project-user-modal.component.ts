import { Component, OnInit } from '@angular/core';
import { ComponentModalConfig, ModalSize, SuiModal } from "ng2-semantic-ui";
import { Project } from "../../../../core/classes/models/project";

export interface IProjectUserModalConfig {
  project: Project;
}

@Component({
  selector: 'app-project-user-modal',
  templateUrl: './project-user-modal.component.html'
})
export class ProjectUserModalComponent implements OnInit {

  project: Project = this.modal.context.project;

  constructor(public modal: SuiModal<IProjectUserModalConfig, void>) { }

  ngOnInit() {
  }

}

export class ProjectUserModal extends ComponentModalConfig<IProjectUserModalConfig, void> {

  constructor(
    project: Project,
    size = ModalSize.Large,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(ProjectUserModalComponent, { project });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
    this.mustScroll = true;
  }

}
