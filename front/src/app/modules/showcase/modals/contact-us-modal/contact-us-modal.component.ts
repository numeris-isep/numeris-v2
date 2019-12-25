import { Component, OnInit } from '@angular/core';
import { SuiModal, ComponentModalConfig, ModalSize } from 'ng2-semantic-ui';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ContactUsService } from '../../../../core/http/contact-us.service';
import { AlertService } from '../../../../core/services/alert.service';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';

@Component({
  selector: 'contact-us-modal',
  templateUrl: './contact-us-modal.component.html',
  styleUrls: ['./contact-us-modal.component.css']
})
export class ContactUsModalComponent implements OnInit {

  contactUsForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    public modal: SuiModal<void, void, void>,
    private formBuilder: FormBuilder,
    private contactUsService: ContactUsService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.contactUsForm = this.formBuilder.group({
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      email: ['', Validators.required],
      subject: ['', Validators.required],
      content: ['', Validators.required]
    });
  }

  // convenient getter for easy access to form fields
  get f() { return this.contactUsForm.controls; }

  onSubmit() {
    this.submitted = true;

    // stop here if form is invalid
    if (this.contactUsForm.invalid) { return; }

    this.loading = true;

    this.contactUsService.contactUs(this.contactUsForm.value).subscribe(
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

export class ContactUsModal extends ComponentModalConfig<void, void, void> {

  constructor(
    size = ModalSize.Normal,
    isClosable: boolean = false,
    transitionDuration: number = 200
  ) {
    super(ContactUsModalComponent);

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }
}
