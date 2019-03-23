import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { Mission } from "../classes/models/mission";
import { environment } from "../../../environments/environment";
import { HTTP_OPTIONS } from "../constants/http_options";

@Injectable({
  providedIn: 'root'
})
export class MissionService {

  constructor(private http: HttpClient) { }

  getMissions(): Observable<Mission[]> {
    const url = `${environment.apiUrl}/api/missions`;
    return this.http.get<Mission[]>(url, HTTP_OPTIONS);
  }

  getMission(mission: Mission): Observable<Mission> {
    const url = `${environment.apiUrl}/api/missions/${mission.id}`;
    return this.http.get<Mission>(url, HTTP_OPTIONS);
  }

  addMission() {
    // TODO
  }

  updateMission() {
    // TODO
  }

  updateMissionLock() {
    // TODO
  }

  destroyMission() {
    // TODO
  }
}
