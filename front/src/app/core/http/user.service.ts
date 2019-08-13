import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { User } from '../classes/models/user';
import { HTTP_OPTIONS } from '../constants/http_options';
import { environment } from '../../../environments/environment';
import { PaginatedUser } from '../classes/pagination/paginated-user';
import { Project } from '../classes/models/project';
import { Mission } from '../classes/models/mission';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private http: HttpClient) { }

  getUsers(project?: number | Project): Observable<PaginatedUser> {
    let projectPath = '';

    if (project) {
      const projectId = typeof project === 'number' ? project : project.id;
      projectPath = `/projects/${projectId}`;
    }

    const url = `${environment.apiUrl}/api${projectPath}/users`;
    return this.http.get<PaginatedUser>(url, HTTP_OPTIONS);
  }

  getPaginatedUsers(
    project?: number | Project,
    pageId?: number,
    search?: string,
    role?: string,
    promotion?: string,
    inProject: boolean = null
  ): Observable<PaginatedUser> {
    let projectPath = '';

    if (project) {
      const projectId = typeof project === 'number' ? project : project.id;
      projectPath = `/projects/${projectId}`;
    }

    let url = `${environment.apiUrl}/api${projectPath}/users?`;

    if (pageId) { url += `&page=${pageId}`; }
    if (search) { url += `&search=${search}`; }
    if (role != null) { url += `&role=${role}`; }
    if (promotion != null) { url += `&promotion=${promotion}`; }
    if (inProject) { url += `&inProject=false`; }

    return this.http.get<PaginatedUser>(url, HTTP_OPTIONS);
  }

  getPaginatedUsersNotInProject(
    project: Project,
    pageId?: number,
    search?: string,
    role?: string,
    promotion?: string
  ): Observable<PaginatedUser> {
    return this.getPaginatedUsers(project, pageId, search, role, promotion, true);
  }

  getProjectUsers(project: number | Project): Observable<User[]> {
    const projectId = typeof project === 'number' ? project : project.id;
    const url = `${environment.apiUrl}/api/projects/${projectId}/users`;
    return this.http.get<User[]>(url, HTTP_OPTIONS);
  }

  getPaginatedMissionUsers(
    mission?: number | Mission,
    pageId?: number,
    search?: string,
    role?: string,
    promotion?: string
  ): Observable<PaginatedUser> {
    let missionPath = '';

    if (mission) {
      const missionId = typeof mission === 'number' ? mission : mission.id;
      missionPath = `/missions/${missionId}`;
    }

    let url = `${environment.apiUrl}/api${missionPath}/users?`;

    if (pageId) { url += `&page=${pageId}`; }
    if (search) { url += `&search=${search}`; }
    if (role != null) { url += `&role=${role}`; }
    if (promotion != null) { url += `&promotion=${promotion}`; }

    return this.http.get<PaginatedUser>(url, HTTP_OPTIONS);
  }

  getUser(userId: number): Observable<User> {
    const url = `${environment.apiUrl}/api/users/${userId}`;
    return this.http.get<User>(url, HTTP_OPTIONS);
  }

  getPromotions(): Observable<string[]> {
    const url = `${environment.apiUrl}/api/users-promotion`;
    return this.http.get<string[]>(url, HTTP_OPTIONS);
  }

  updateUser(data: User, user: User | number): Observable<User> {
    const userId: number = typeof user === 'number' ? user : user.id;
    const url = `${environment.apiUrl}/api/users/${userId}`;
    return this.http.put<User>(url, data, HTTP_OPTIONS);
  }

  updateUserTermsOfUse(user: User) {
    const url = `${environment.apiUrl}/api/users/${user.id}/terms-of-use`;
    return this.http.patch(url, { tou_accepted: true }, HTTP_OPTIONS);
  }

  deleteUser(user: User) {
    // TODO
  }
}
