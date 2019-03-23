import { Component, OnInit } from '@angular/core';
import { SuiModal, ComponentModalConfig, ModalSize } from "ng2-semantic-ui"
import { Mission } from "../../../../core/classes/models/mission";
import { Application } from "../../../../core/classes/models/application";
import { ApplicationService } from "../../../../core/http/application.service";
import { AlertService } from "../../../../core/services/alert.service";
import { Router } from "@angular/router";
import { Observable } from "rxjs";
import { AuthService } from "../../../../core/http/auth/auth.service";

export interface IConfirmModalContext {
  title: string;
  question: string;
  mission: Mission;
  application: Application;
}

@Component({
  selector: 'confirm-modal',
  templateUrl: './confirm-modal.component.html'
})
export class ConfirmModalComponent implements OnInit {

  mission: Mission = this.modal.context.mission;
  application: Application = this.modal.context.application;
  returnUrl: string = this.router.url;

  loading: boolean = false;

  constructor(
    public modal: SuiModal<IConfirmModalContext, void, void>,
    private applicationService: ApplicationService,
    private authService: AuthService,
    private alertService: AlertService,
    private router: Router
  ) { }

  ngOnInit() {
  }

  onClick() {
    this.loading = true;

    if (! this.application) {
      this.storeUserApplication(this.mission).subscribe(
        _ => {
          this.router.navigate(['/'])
            .then(() => { this.router.navigate([this.returnUrl]) } );
          this.alertService.success(`Vous avez bien postulé à la mission ${this.mission.title}.`, null, true);
          this.modal.approve(undefined);
        },
        error => {
          this.loading = false;
          console.log(error);
        }
      );
    } else {
      this.destroyUserApplication(this.application).subscribe(
        _ => {
          this.router.navigate(['/'])
            .then(() => { this.router.navigate([this.returnUrl]) } );
          this.alertService.success(`Candidature à la mission ${this.mission.title} retirée.`, null, true);
          this.modal.approve(undefined);
        },
        error => {
          this.loading = false;
          console.log(error);
        }
      );
    }
  }

  storeUserApplication(mission: Mission) {
    return this.applicationService.storeUserApplication(
      this.authService.getCurrentUserId(),
      mission
    );
  }

  destroyUserApplication(application: Application): Observable<Application> {
    return this.applicationService.destroyApplication(application);
  }
}

export class ConfirmModal extends ComponentModalConfig<IConfirmModalContext, void, void> {

  constructor(
    title: string,
    question: string,
    mission: Mission,
    application: Application,
    size = ModalSize.Small,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(ConfirmModalComponent, { title, question, mission, application });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }
}
