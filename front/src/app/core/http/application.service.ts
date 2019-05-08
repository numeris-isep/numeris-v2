import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable, of } from "rxjs";
import { environment } from "../../../environments/environment";
import { HTTP_OPTIONS } from "../constants/http_options";
import { Application, ApplicationStatus } from "../classes/models/application";
import { User } from "../classes/models/user";
import { Mission } from '../classes/models/mission';

@Injectable({
  providedIn: 'root'
})
export class ApplicationService {

  constructor(private http: HttpClient) { }

  getApplicationStatuses(): Observable<ApplicationStatus[]> {
    const url = `${environment.apiUrl}/api/applications-statuses`;
    return this.http.get<ApplicationStatus[]>(url, HTTP_OPTIONS);
  }

  updateApplication(status: string, application: Application | number): Observable<Application> {
    const missionId: number = typeof application === 'number' ? application : application.id;
    const url = `${environment.apiUrl}/api/applications/${missionId}`;
    return this.http.patch<Application>(url, {status: status}, HTTP_OPTIONS);
  }

  deleteApplication(application: Application): Observable<Application> {
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

  getMissionApplications(mission: Mission): Observable<Application[]> {
    const url = `${environment.apiUrl}/api/missions/${mission.id}/applications`;
    return this.http.get<Application[]>(url, HTTP_OPTIONS);
  }

  storeMissionApplication(mission: Mission | number, user: User) {
    const missionId = typeof mission === 'number' ? mission : mission.id;
    const url = `${environment.apiUrl}/api/missions/${missionId}/applications`;
    const data = { user_id: user.id };
    return this.http.post<Application>(url, data, HTTP_OPTIONS);
  }
}
