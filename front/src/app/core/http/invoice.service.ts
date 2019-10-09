import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';
import { HTTP_OPTIONS } from '../constants/http_options';
import { Invoice } from '../classes/models/Invoice';

@Injectable({
  providedIn: 'root'
})
export class InvoiceService {

  constructor(private http: HttpClient) { }

  getInvoices(year: string): Observable<Invoice[]> {
    const url = `${environment.apiUrl}/api/invoices`;
    return this.http.post<Invoice[]>(url, {year: year}, HTTP_OPTIONS);
  }

}
