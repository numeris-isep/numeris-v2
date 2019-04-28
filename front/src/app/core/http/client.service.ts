import { Injectable } from '@angular/core';
import { Client } from "../classes/models/client";
import { environment } from "../../../environments/environment";
import { HTTP_OPTIONS } from "../constants/http_options";
import { HttpClient } from "@angular/common/http";
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ClientService {

  constructor(private http: HttpClient) { }

  getClients(): Observable<Client[]> {
    const url = `${environment.apiUrl}/api/clients`;
    return this.http.get<Client[]>(url, HTTP_OPTIONS);
  }

  getClient(clientId: number): Observable<Client> {
    const url = `${environment.apiUrl}/api/clients/${clientId}`;
    return this.http.get<Client>(url, HTTP_OPTIONS);
  }

  addClient(data: Client): Observable<Client> {
    const url = `${environment.apiUrl}/api/clients`;
    return this.http.post<Client>(url, data, HTTP_OPTIONS);
  }

 updateClient(data: Client, client: Client | number): Observable<Client> {
    const clientId: number = typeof client === 'number' ? client : client.id;
    const url = `${environment.apiUrl}/api/clients/${clientId}`;
    return this.http.put<Client>(url, data, HTTP_OPTIONS);
 }

 deleteClient(client: Client): Observable<Client> {
   const clientId: number = typeof client === 'number' ? client : client.id;
   const url = `${environment.apiUrl}/api/clients/${clientId}`;
   return this.http.delete<Client>(url, HTTP_OPTIONS);
 }

}
