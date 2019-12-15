import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Mission } from '../classes/models/mission';
import { environment } from '../../../environments/environment';
import { HTTP_OPTIONS } from '../constants/http_options';
import { PaginatedMission } from '../classes/pagination/paginated-mission';
import { Project } from '../classes/models/project';
import { Application } from '../classes/models/application';
import { Email } from '../classes/email';

@Injectable({
  providedIn: 'root'
})
export class MissionService {

  constructor(private http: HttpClient) { }

  getMissions(project?: number | Project): Observable<PaginatedMission> {
    let projectPath = '';

    if (project) {
      const projectId = typeof project === 'number' ? project : project.id;
      projectPath = `/projects/${projectId}`;
    }

    const url = `${environment.apiUrl}/api/missions`;
    return this.http.get<PaginatedMission>(url, HTTP_OPTIONS);
  }

  getPaginatedMissions(
    project?: number | Project,
    pageId?: number,
    isLocked?: any,
    range?: [string, string]
  ): Observable<PaginatedMission> {
    let projectPath = '';

    if (project) {
      const projectId = typeof project === 'number' ? project : project.id;
      projectPath = `/projects/${projectId}`;
    }

    let url = `${environment.apiUrl}/api${projectPath}/missions?`;

    if (pageId) { url += `&page=${pageId}`; }
    if (isLocked != null) { url += `&isLocked=${isLocked}`; }
    if (range) {
      if (range[0]) { url += `&minDate=${range[0]}`; }
      if (range[1]) { url += `&maxDate=${range[1]}`; }
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

  addMission(data: Mission): Observable<Mission> {
    const url = `${environment.apiUrl}/api/missions`;
    return this.http.post<Mission>(url, data, HTTP_OPTIONS);
  }

  updateMission(data: Mission, mission: Mission | number): Observable<Mission> {
    const missionId: number = typeof mission === 'number' ? mission : mission.id;
    const url = `${environment.apiUrl}/api/missions/${missionId}`;
    return this.http.put<Mission>(url, data, HTTP_OPTIONS);
  }

  updateMissionLock(isLocked: boolean, mission: Mission | number): Observable<Mission> {
    const missionId: number = typeof mission === 'number' ? mission : mission.id;
    const url = `${environment.apiUrl}/api/missions/${missionId}/lock`;
    return this.http.patch<Mission>(url, {is_locked: isLocked}, HTTP_OPTIONS);
  }

  updateMissionBills(data: any, mission: Mission | number): Observable<Application[]> {
    const missionId: number = typeof mission === 'number' ? mission : mission.id;
    const url = `${environment.apiUrl}/api/missions/${missionId}/bills`;
    return this.http.put<Application[]>(url, data, HTTP_OPTIONS);
  }

  deleteMission(mission: Mission | number): Observable<Mission> {
    const missionId: number = typeof mission === 'number' ? mission : mission.id;
    const url = `${environment.apiUrl}/api/missions/${missionId}`;
    return this.http.delete<Mission>(url, HTTP_OPTIONS);
  }

  sendEmail(mission: Mission | number, email: Email): Observable<Mission> {
    const missionId: number = typeof mission === 'number' ? mission : mission.id;
    const url = `${environment.apiUrl}/api/missions/${missionId}/email`;
    return this.http.post<Mission>(url, email, HTTP_OPTIONS);
  }

  notifyAvailability(data: number[]): Observable<any> {
    const url = `${environment.apiUrl}/api/missions/notify`;
    return this.http.post<any>(url, {missions: data}, HTTP_OPTIONS);
  }
}
