import { AfterViewInit, Component, Input, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Client } from '../../../../core/classes/models/client';
import { ClientService } from '../../../../core/http/client.service';
import { first } from 'rxjs/operators';
import { Router } from '@angular/router';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';
import { Observable } from 'rxjs';
import { AlertService } from '../../../../core/services/alert.service';
import { Contact } from '../../../../core/classes/models/contact';
import { ContactService } from '../../../../core/http/contact.service';

@Component({
  selector: 'app-client-form',
  templateUrl: './client-form.component.html'
})
export class ClientFormComponent implements OnInit, AfterViewInit {

  @Input() client: Client;

  clientForm: FormGroup;
  initialValue: object;
  loading: boolean = false;
  submitted: boolean = false;
  contacts: Contact[];

  constructor(
    private fb: FormBuilder,
    private clientService: ClientService,
    private contactService: ContactService,
    private alertService: AlertService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.getContacts();
    this.initForm();
  }

  ngAfterViewInit() {
    this.initialValue = this.clientForm.value;
  }

  initForm() {
    this.clientForm = this.fb.group({
      name: [
        this.client ? this.client.name : '',
        Validators.required,
      ],
      time_limit: [
        this.client ? this.client.timeLimit : '',
        Validators.required,
      ],
      contact_id: [this.client ? (this.client.contact ? this.client.contact.id : '') : ''],
    });
  }

  get f() { return this.clientForm.controls; }

  addAddressForm(addressForm: FormGroup) {
    this.clientForm.addControl('address', addressForm);
  }

  onSubmit() {
    this.submitted = true;

    if (this.clientForm.invalid) { return; }

    this.loading = true;
    let clientRequest: Observable<Client>;

    if (!this.client) {
      clientRequest = this.clientService.addClient(this.clientForm.value as Client);
    } else {
      clientRequest = this.clientService.updateClient(this.clientForm.value as Client, this.client);
    }

    clientRequest.pipe(first())
      .subscribe(
        client => {
          this.loading = false;
          this.router.navigate([`/clients/${client.id}`]);
          if (this.client) { this.alertService.success([`Le client ${client.name} a bien ??t?? modifi??.`]); }
        },
        errors => {
          handleFormErrors(this.clientForm, errors);
          this.loading = false;
        }
      );
  }

  getContacts() {
    this.contactService.getContacts().subscribe(contacts => this.contacts = contacts);
  }

  fullName(option: Contact, query?: string): string {
    return `${option.firstName} ${option.lastName.toUpperCase()}`;
  }

}
