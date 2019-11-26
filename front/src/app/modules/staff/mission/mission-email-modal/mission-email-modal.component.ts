import { Component, OnInit, TemplateRef, ViewChild } from '@angular/core';
import { Mission } from '../../../../core/classes/models/mission';
import { ComponentModalConfig, ModalSize } from 'ng2-semantic-ui';
import { SuiModal } from 'ng2-semantic-ui';
import { FormGroup } from '@angular/forms';
import { MissionService } from '../../../../core/http/mission.service';
import { Email } from '../../../../core/classes/email';
import { first } from 'rxjs/operators';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';
import { AlertService } from '../../../../core/services/alert.service';
import * as moment from 'moment';
import { PhonePipe } from '../../../../shared/pipes/phone.pipe';

export interface IMissionEmailModalConfig {
  mission: Mission;
}

@Component({
  selector: 'app-mission-email-modal',
  templateUrl: './mission-email-modal.component.html'
})
export class MissionEmailModalComponent implements OnInit {

  mission: Mission = this.modal.context.mission;
  loading: boolean = false;
  submitted: boolean = false;
  emailForm: FormGroup;
  email: Email;

  @ViewChild('emailContent') emailContent: TemplateRef<string>;

  constructor(
    public modal: SuiModal<IMissionEmailModalConfig, void>,
    private missionService: MissionService,
    private alertService: AlertService,
    private phonePipe: PhonePipe,
  ) { }

  ngOnInit() {
    this.email = this.generateEmail();
  }

  generateEmail(): Email {
    return {
      subject: this.mission.title,
      content: this.content,
    };
  }

  get f() { return this.emailForm.controls; }

  addEmailForm(emailForm: FormGroup) {
    this.emailForm = emailForm;
  }

  onSubmit() {
    this.submitted = true;

    if (this.emailForm.invalid) { return; }

    this.loading = true;

    this.missionService.sendEmail(this.mission, this.emailForm.value as Email)
      .pipe(first())
      .subscribe(
        () => {
          this.loading = false;
          this.modal.approve(undefined);
          this.alertService.success(['L\'email a bien été envoyé aux étudiants acceptés sur la mission.']);
        },
        errors => {
          handleFormErrors(this.emailForm, errors);
          this.loading = false;
        }
      );
  }

  get content() {
    let content = '<p>Bonjour,</p>'
      + '<p>Vous avez été sélectionné pour la mission suivante : </p>'
      + `<p><strong>${this.mission.title} </strong>le <strong> `
      + `${moment(this.mission.startAt).locale('fr-FR').format('dddd D MMMM Y à HH[h]mm')}</strong>.</p>`
      + `<p><i>${this.mission.address.street}, ${this.mission.address.zipCode} ${this.mission.address.city}</i></p>`;

    if (this.mission.contact) {
      content += `<p>Votre contact sur place sera <i>${this.mission.contact.firstName} ${this.mission.contact.lastName.toUpperCase()} </i>`;

      if (this.mission.contact.phone) {
        content += `que vous pouvez joindre au <i>${this.phonePipe.transform(this.mission.contact.phone)} </i>en cas de problème.`;
      }

      content += `</p>`;
    }

    content += `<p><strong>Soyez impérativement à l'heure, veuillez vous montrer sérieux et `
      + `efficace et venir avec une tenue vestimentaire correcte.</strong></p>`
      + `<p>N'oubliez pas de prendre :</p>`
      + `<ul><li>votre <i>carte d'identité</i> (nécessaire pour accéder au site)</li>`
      + `<li>une <i>pince coupante</i></li><li>un<i> stylo</i></li></ul>`
      + `<p>N'hésitez pas à contacter <i>${this.mission.user.firstName} ${this.mission.user.lastName.toUpperCase()} </i>`
      + `au <i>${this.phonePipe.transform(this.mission.user.phone)}</i> pour toute question.</p>`
      + `<p>Cordialement,</p><p>L'équipe Numéris.</p>`;

    return content;
  }

}

export class MissionEmailModal extends ComponentModalConfig<IMissionEmailModalConfig, void> {

  constructor(
    mission: Mission,
    size = ModalSize.Large,
    isClosable: boolean = false,
    transitionDuration: number = 200
  ) {
    super(MissionEmailModalComponent, { mission });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
    this.mustScroll = true;
  }

}
