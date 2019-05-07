import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { Contact } from "../classes/models/contact";
import { environment } from "../../../environments/environment";
import { HTTP_OPTIONS } from "../constants/http_options";

@Injectable({
  providedIn: 'root'
})
export class ContactService {

  constructor(private http: HttpClient) { }

  getContacts(): Observable<Contact[]> {
    const url = `${environment.apiUrl}/api/contacts`;
    return this.http.get<Contact[]>(url, HTTP_OPTIONS);
  }

  // addContact(): Observable<Contact> {}

  // updateContact(): Observable<Contact> {}

  // deleteContact(): Observable<Contact> {}

}
