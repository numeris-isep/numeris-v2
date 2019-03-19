import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { environment } from "../../../environments/environment";
import { HTTP_OPTIONS } from "../constants/http_options";
import { Application } from "../classes/models/application";

@Injectable({
  providedIn: 'root'
})
export class ApplicationService {

  constructor(private http: HttpClient) { }

  updateApplication() {
    //
  }

  destroyApplication() {
    //
  }

  getUserApplications(user_id: number): Observable<Application[]> {
    const url = `${environment.apiUrl}/api/users/${user_id}/applications`;
    return this.http.get<Application[]>(url, HTTP_OPTIONS);
  }

  storeUserApplication() {
    //
  }

  storeMissionApplication() {
    //
  }
}
