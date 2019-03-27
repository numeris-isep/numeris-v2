import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { Mission } from "../classes/models/mission";
import { environment } from "../../../environments/environment";
import { HTTP_OPTIONS } from "../constants/http_options";
import { PaginatedMission } from "../classes/pagination/paginated-mission";

@Injectable({
  providedIn: 'root'
})
export class MissionService {

  constructor(private http: HttpClient) { }

  getMissions(): Observable<PaginatedMission> {
    const url = `${environment.apiUrl}/api/missions`;
    return this.http.get<PaginatedMission>(url, HTTP_OPTIONS);
  }

  getMissionsPerPage(pageId?: number, isLocked?: any, range?: [string, string]): Observable<PaginatedMission> {
    let url = `${environment.apiUrl}/api/missions?`;

    if (pageId) url += `&page=${pageId}`;
    if (isLocked != null) url += `&isLocked=${isLocked}`;
    if (range) {
      if (range[0]) url += `&minDate=${range[0]}`;
      if (range[1]) url += `&maxDate=${range[1]}`;
    }

    return this.http.get<PaginatedMission>(url, HTTP_OPTIONS);
  }

  getAvailableMissions(): Observable<Mission[]> {
    const url = `${environment.apiUrl}/api/missions-available`;
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
