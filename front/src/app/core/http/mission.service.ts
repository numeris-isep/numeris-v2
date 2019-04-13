import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { Mission } from "../classes/models/mission";
import { environment } from "../../../environments/environment";
import { HTTP_OPTIONS } from "../constants/http_options";
import { PaginatedMission } from "../classes/pagination/paginated-mission";
import { Project } from "../classes/models/project";

@Injectable({
  providedIn: 'root'
})
export class MissionService {

  constructor(private http: HttpClient) { }

  getMissions(project?: number | Project): Observable<PaginatedMission> {
    let projectPath: string = '';

    if (project) {
      const projectId = typeof project === 'number' ? project : project.id;
      projectPath = `/projects/${projectId}`;
    }

    const url = `${environment.apiUrl}/api/missions`;
    return this.http.get<PaginatedMission>(url, HTTP_OPTIONS);
  }

  getMissionsPerPage(project?: number | Project, pageId?: number, isLocked?: any, range?: [string, string]): Observable<PaginatedMission> {
    let projectPath: string = '';

    if (project) {
      const projectId = typeof project === 'number' ? project : project.id;
      projectPath = `/projects/${projectId}`;
    }

    let url = `${environment.apiUrl}/api${projectPath}/missions?`;

    if (pageId) url += `&page=${pageId}`;
    if (isLocked != null) url += `&isLocked=${isLocked}`;
    if (range) {
      if (range[0]) url += `&minDate=${range[0]}`;
      if (range[1]) url += `&maxDate=${range[1]}`;
    }

    return this.http.get<PaginatedMission>(url, HTTP_OPTIONS);
  }

  getProjectMissions(project?: number | Project): Observable<Mission[]> {
    const projectId = typeof project === 'number' ? project : project.id;
    const url = `${environment.apiUrl}/api/projects/${projectId}/missions`;
    return this.http.get<Mission[]>(url, HTTP_OPTIONS);
  }

  getAvailableMissions(): Observable<Mission[]> {
    const url = `${environment.apiUrl}/api/missions-available`;
    return this.http.get<Mission[]>(url, HTTP_OPTIONS);
  }

  getMission(missionId: number): Observable<Mission> {
    const url = `${environment.apiUrl}/api/missions/${missionId}`;
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
