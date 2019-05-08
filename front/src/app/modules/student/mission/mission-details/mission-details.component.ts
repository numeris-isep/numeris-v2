import { Component, Input, OnInit } from '@angular/core';
import { Mission } from "../../../../core/classes/models/mission";
import * as moment from "moment";
import { ConfirmModal } from "../../application/application-confirm-modal/application-confirm-modal.component";
import { SuiModalService } from "ng2-semantic-ui";
import { ApplicationService } from "../../../../core/http/application.service";
import { Application } from "../../../../core/classes/models/application";
import { AuthService } from "../../../../core/http/auth/auth.service";
import { MissionDeleteModal } from "../../../staff/mission/mission-delete-modal/mission-delete-modal.component";
import { ApplicationHandlerService } from "../../../../core/services/application-handler.service";

@Component({
  selector: 'app-mission-details',
  templateUrl: './mission-details.component.html',
  styleUrls: [
    './mission-details.component.css',
    '../../../staff/project/project.component.css'
  ]
})
export class MissionDetailsComponent implements OnInit {

  @Input() mission: Mission;
  @Input() color: string = 'blue';
  @Input() page: string;
  userApplication: Application;
  currentUserId: number;

  acceptedApplications: Application[];

  private applicationModal: ConfirmModal;
  private deleteModal: MissionDeleteModal;

  constructor(
    private modalService: SuiModalService,
    private applicationService: ApplicationService,
    private applicationHandlerService: ApplicationHandlerService,
    private authService: AuthService
  ) { }

  ngOnInit() {
    this.currentUserId = this.authService.getCurrentUserId();
    this.mission.applications
      .filter((application) => {
        if (application.userId == this.currentUserId) {
          this.userApplication =  application;
        }
      });

    if (this.page == 'show') {
      this.deleteModal = new MissionDeleteModal(
        this.mission.title,
        `Voulez-vous vraiment supprimer la mission ${this.mission.title} ?`,
        this.mission
      );
      this.getAcceptedApplications();
    } else {
      this.applicationModal = new ConfirmModal(
        'Continuer ?',
        ! this.userApplication
          ? `Êtes-vous sûr de vouloir postuler pour la mission ${this.mission.title} ?`
          : `Êtes-vous sûr de vouloir retirer votre candidature de la mission ${this.mission.title} ?`,
        this.mission,
        this.userApplication
      )
    }
  }

  getAcceptedApplications() {
    if (this.applicationHandlerService.getApplications('accepted')) {
      this.applicationHandlerService.getApplications('accepted').subscribe(applications => this.acceptedApplications = applications);
    }
  }

  isMissionExpired() {
    return moment(this.mission.startAt).isBefore(moment());
  }

  openModal() {
    this.modalService.open(
      this.page == 'show' ? this.deleteModal : this.applicationModal
    );
  }
}
