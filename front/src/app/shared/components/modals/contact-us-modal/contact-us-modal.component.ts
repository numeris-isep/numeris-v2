import { Component, OnInit } from '@angular/core';
import { SuiModal, ComponentModalConfig, ModalSize } from "ng2-semantic-ui"
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ActivatedRoute, Router } from "@angular/router";
import { AuthService } from "../../../../core/auth/auth.service";
import { TokenService } from "../../../../core/services/token.service";
import { AlertService } from "../../alert/alert.service";
import { first } from "rxjs/operators";

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
    private formBuilder: FormBuilder
  ) { }

  ngOnInit() {
    this.contactUsForm = this.formBuilder.group({
      firstName: ['', Validators.required],
      lastName: ['', Validators.required],
      email: ['', Validators.required],
      subject: ['', Validators.required],
      message: ['', Validators.required]
    });
  }

  // convenient getter for easy access to form fields
  get f() { return this.contactUsForm.controls; }

  onSubmit() {
    this.submitted = true;

    // stop here if form is invalid
    if (this.contactUsForm.invalid) { return; }

    this.loading = true;
    // TODO
  }
}

export class ContactUsModal extends ComponentModalConfig<void, void, void> {

  constructor(
    size = ModalSize.Large,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(ContactUsModalComponent);

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }
}
