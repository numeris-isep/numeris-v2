import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ContactUsService {

  constructor(private http: HttpClient) { }

  contactUs(
    data: {
      first_name: string,
      last_name: string,
      email: string,
      subject: string,
      content: string,
    }
  ): Observable<[]> {
    const url = `${environment.apiUrl}/api/contact-us`;
    return this.http.post<[]>(url, data);
  }
}
