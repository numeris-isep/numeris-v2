import { Component, OnInit } from '@angular/core';
import { SuiModal, ComponentModalConfig, ModalSize } from 'ng2-semantic-ui';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ContactUsService } from '../../../../core/http/contact-us.service';
import { AlertService } from '../../../../core/services/alert.service';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';
import { User } from '../../../../core/classes/models/user';
import { environment } from '../../../../../environments/environment';

export interface IContactUsModal {
  user: User;
}

@Component({
  selector: 'contact-us-modal',
  templateUrl: './contact-us-modal.component.html',
  styleUrls: ['./contact-us-modal.component.css']
})
export class ContactUsModalComponent implements OnInit {

  contactUsForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;
  user: User = this.modal.context.user;

  captchaKey: string = environment.captchaKey;

  constructor(
    public modal: SuiModal<IContactUsModal, void, void>,
    private formBuilder: FormBuilder,
    private contactUsService: ContactUsService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.contactUsForm = this.formBuilder.group({
      first_name: [this.user ? this.user.firstName : '', Validators.required],
      last_name: [this.user ? this.user.lastName : '', Validators.required],
      email: [this.user ? this.user.email : '', Validators.required],
      subject: ['', Validators.required],
      content: ['', Validators.required]
    });
  }

  // convenient getter for easy access to form fields
  get f() { return this.contactUsForm.controls; }

  onSubmit(reCaptchaToken: string) {
    this.submitted = true;

    // stop here if form is invalid
    if (this.contactUsForm.invalid) { return; }

    this.loading = true;

    this.contactUsService.contactUs(this.contactUsForm.value, reCaptchaToken).subscribe(
      () => {
        this.alertService.success(['Votre message a bien été envoyé.']);
        this.modal.approve(null);
        this.loading = false;
      },
      errors => {
        handleFormErrors(this.contactUsForm, errors);
        this.loading = false;
      }
    );
  }
}

export class ContactUsModal extends ComponentModalConfig<IContactUsModal, void, void> {

  constructor(
    user: User = null,
    size = ModalSize.Normal,
    isClosable: boolean = false,
    transitionDuration: number = 200,
  ) {
    super(ContactUsModalComponent, { user: user });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }
}
