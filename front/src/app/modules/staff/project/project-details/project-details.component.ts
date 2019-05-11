import { Component, Input, OnInit } from '@angular/core';
import { Project } from "../../../../core/classes/models/project";
import { ProjectDeleteModal } from "../project-delete-modal/project-delete-modal.component";
import { SuiModalService } from "ng2-semantic-ui";
import { User } from "../../../../core/classes/models/user";

@Component({
  selector: 'app-project-details',
  templateUrl: './project-details.component.html',
  styleUrls: [
    './../project.component.css',
    '../../client/client-details/client-details.component.css'
  ]
})
export class ProjectDetailsComponent implements OnInit {

  @Input() project: Project;
  @Input() users: User[] = [];

  private deleteModal: ProjectDeleteModal;

  constructor(private modalService: SuiModalService) { }

  ngOnInit() {
    this.deleteModal =  new ProjectDeleteModal(
      this.project.name,
      `Voulez-vous vraiment supprimer le projet ${this.project.name} ?`,
      this.project
    );
  }

  openModal() {
    this.modalService.open(this.deleteModal);
  }

}
