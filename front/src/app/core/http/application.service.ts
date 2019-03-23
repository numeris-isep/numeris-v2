import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable, of } from "rxjs";
import { environment } from "../../../environments/environment";
import { HTTP_OPTIONS } from "../constants/http_options";
import { Application } from "../classes/models/application";
import { User } from "../classes/models/user";
import { Mission } from "../classes/models/mission";

@Injectable({
  providedIn: 'root'
})
export class ApplicationService {

  constructor(private http: HttpClient) { }

  updateApplication() {
    //
  }

  destroyApplication(application: Application): Observable<Application> {
    const url = `${environment.apiUrl}/api/applications/${application.id}`;
    return this.http.delete<Application>(url, HTTP_OPTIONS);
  }

  getUserApplications(user: User): Observable<Application[]> {
    const url = `${environment.apiUrl}/api/users/${user.id}/applications`;
    return this.http.get<Application[]>(url, HTTP_OPTIONS);
  }

  storeUserApplication(user: User | number, mission: Mission): Observable<Application> {
    const userId = typeof user === 'number' ? user : user.id;
    const url = `${environment.apiUrl}/api/users/${userId}/applications`;
    const data = { mission_id: mission.id };
    return this.http.post<Application>(url, data, HTTP_OPTIONS);
  }

  storeMissionApplication() {
    //
  }
}
