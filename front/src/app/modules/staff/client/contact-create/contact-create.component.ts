import { Component, OnInit, ViewChild } from '@angular/core';
import { CanComponentDeactivate } from '../../../../core/guards/deactivate.guard';
import { ContactFormComponent } from '../contact-form/contact-form.component';
import { equals } from '../../../../shared/utils';

@Component({
  selector: 'app-contact-create',
  templateUrl: './contact-create.component.html'
})
export class ContactCreateComponent implements OnInit, CanComponentDeactivate {

  @ViewChild(ContactFormComponent) contactFormComponent: ContactFormComponent;

  constructor() { }

  ngOnInit() {
  }

  canDeactivate() {
    return equals(
      this.contactFormComponent.initialValue,
      this.contactFormComponent.contactForm.value
    );
  }

}
