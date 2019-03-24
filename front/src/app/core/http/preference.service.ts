import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { Preference } from "../classes/models/preference";
import { environment } from "../../../environments/environment";
import { HTTP_OPTIONS } from "../constants/http_options";

@Injectable({
  providedIn: 'root'
})
export class PreferenceService {

  constructor(private http: HttpClient) { }

  updatePreference(preference: Preference): Observable<Preference> {
    const url = `${environment.apiUrl}/api/preferences/${preference.id}`;
    return this.http.put<Preference>(url, preference, HTTP_OPTIONS);
  }
}
