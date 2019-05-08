import { Component, Input, OnInit } from '@angular/core';
import { Contact } from 'src/app/core/classes/models/contact';
import { ContactService } from "../../../../core/http/contact.service";
import { AlertService } from "../../../../core/services/alert.service";

@Component({
  selector: 'app-contact-list',
  templateUrl: './contact-list.component.html'
})
export class ContactListComponent implements OnInit {

  @Input() contacts: Contact[];

  loading: boolean = false;

  constructor(
    private contactService: ContactService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
  }

  deleteContact(contact: Contact) {
    this.loading = true;
    this.contactService.deleteContact(contact).subscribe(
      () => {
        this.contacts = this.contacts.filter(c => c !== contact);
        this.alertService.success([`Le contact ${contact.firstName} ${contact.lastName.toUpperCase()} a bien été supprimé.`])
        this.loading = false;
      },
      errors => this.loading = false
    )
  }

}
