import { Component, OnInit } from '@angular/core';
import { Contact } from "../../../../core/classes/models/contact";
import { ActivatedRoute } from "@angular/router";
import { TitleService } from "../../../../core/services/title.service";
import { BreadcrumbsService } from "../../../../core/services/breadcrumbs.service";
import { ContactService } from "../../../../core/http/contact.service";

@Component({
  selector: 'app-contact-edit',
  templateUrl: './contact-edit.component.html'
})
export class ContactEditComponent implements OnInit {

  contact: Contact;

  constructor(
    private route: ActivatedRoute,
    private contactService: ContactService,
    private titleService: TitleService,
    private breadcrumbsService: BreadcrumbsService
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getContact(parseInt(param.contactId));
    });
  }

  getContact(contactId: number) {
    return this.contactService.getContact(contactId).subscribe(contact => {
      this.contact = contact;

      this.titleService.setTitles(`${contact.firstName} ${contact.lastName.toUpperCase()} - Modifier`);
      this.breadcrumbsService.addBreadcrumb(
        [
          { title: 'Contacts', url: '/contacts' },
          {
            title: `${contact.firstName} ${contact.lastName.toUpperCase()}`,
            url: `/clients/contacts`
          },
          { title: 'Modifier', url: '' }
        ]
      );
    });
  }

}
