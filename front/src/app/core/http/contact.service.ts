import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Contact } from '../classes/models/contact';
import { environment } from '../../../environments/environment';
import { HTTP_OPTIONS } from '../constants/http_options';

@Injectable({
  providedIn: 'root'
})
export class ContactService {

  constructor(private http: HttpClient) { }

  getContacts(): Observable<Contact[]> {
    const url = `${environment.apiUrl}/api/contacts`;
    return this.http.get<Contact[]>(url, HTTP_OPTIONS);
  }

  getContact(contactId: number): Observable<Contact> {
    const url = `${environment.apiUrl}/api/contacts/${contactId}`;
    return this.http.get<Contact>(url, HTTP_OPTIONS);
  }

  addContact(data: Contact): Observable<Contact> {
    const url = `${environment.apiUrl}/api/contacts`;
    return this.http.post<Contact>(url, data, HTTP_OPTIONS);
  }

  updateContact(data: Contact, contact: Contact): Observable<Contact> {
    const contactId: number = typeof contact === 'number' ? contact : contact.id;
    const url = `${environment.apiUrl}/api/contacts/${contactId}`;
    return this.http.put<Contact>(url, data, HTTP_OPTIONS);
  }

  deleteContact(contact): Observable<Contact> {
    const contactId: number = typeof contact === 'number' ? contact : contact.id;
    const url = `${environment.apiUrl}/api/contacts/${contactId}`;
    return this.http.delete<Contact>(url, HTTP_OPTIONS);
  }

}
