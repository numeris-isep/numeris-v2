import { Component, Input, OnInit } from '@angular/core';
import { Contact } from "../../../../core/classes/models/contact";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ContactService } from "../../../../core/http/contact.service";
import { AlertService } from "../../../../core/services/alert.service";
import { Router } from "@angular/router";
import { Observable } from "rxjs";
import { first } from "rxjs/operators";
import { handleFormErrors } from "../../../../core/functions/form-error-handler";

@Component({
  selector: 'app-contact-form',
  templateUrl: './contact-form.component.html'
})
export class ContactFormComponent implements OnInit {

  @Input() contact: Contact;

  contactForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private fb: FormBuilder,
    private contactService: ContactService,
    private alertService: AlertService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.contactForm = this.fb.group({
      first_name: [
        this.contact ? this.contact.firstName : '',
        Validators.required,
      ],
      last_name: [
        this.contact ? this.contact.lastName : '',
        Validators.required,
      ],
      email: [this.contact ? this.contact.email : ''],
      phone: [this.contact ? this.contact.phone : ''],
    });
  }

  get f() { return this.contactForm.controls; }

  onSubmit() {
    this.submitted = true;

    if (this.contactForm.invalid) return;

    this.loading = true;
    let contactRequest: Observable<Contact>;

    if (!this.contact) {
      contactRequest = this.contactService.addContact(this.contactForm.value as Contact);
    } else {
      contactRequest = this.contactService.addContact(this.contactForm.value as Contact);
    }

    contactRequest.pipe(first())
      .subscribe(
        contact => {
          this.loading = false;
          this.router.navigate(['/clients']);
          if (!this.contact) {
            this.alertService.success([`Le contact client ${contact.firstName} ${contact.lastName.toUpperCase()} a bien été créé.`]);
          } else {
            this.alertService.success([`Le contact client ${contact.firstName} ${contact.lastName.toLocaleUpperCase()} a bien été modifié.`]);
          }
        },
        errors => {
          handleFormErrors(this.contactForm, errors);
          this.loading = false;
        },
      )
  }

}
