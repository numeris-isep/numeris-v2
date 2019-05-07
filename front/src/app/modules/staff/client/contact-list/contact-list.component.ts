import { Component, Input, OnInit } from '@angular/core';
import { Contact } from 'src/app/core/classes/models/contact';

@Component({
  selector: 'app-contact-list',
  templateUrl: './contact-list.component.html'
})
export class ContactListComponent implements OnInit {

  @Input() contacts: Contact[];

  constructor() { }

  ngOnInit() {
  }

}
