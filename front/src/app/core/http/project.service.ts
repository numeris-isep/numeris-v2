import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { environment } from "../../../environments/environment";
import { Observable } from "rxjs";
import { PaginatedProject } from "../classes/pagination/paginated-project";
import { HTTP_OPTIONS } from "../constants/http_options";
import { Client } from "../classes/models/client";
import { Project } from "../classes/models/project";

@Injectable({
  providedIn: 'root'
})
export class ProjectService {

  constructor(private http: HttpClient) { }

  getProjects(client?: number | Client): Observable<PaginatedProject> {
    let clientPath: string = '';

    if (client) {
      const clientId = typeof client === 'number' ? client : client.id;
      clientPath = `/clients/${clientId}`;
    }

    const url = `${environment.apiUrl}/api${clientPath}/projects`;
    return this.http.get<PaginatedProject>(url, HTTP_OPTIONS);
  }

  getProjectsPerPage(client?: number | Client, pageId?: number, step?: any, range?: [string, string]): Observable<PaginatedProject> {
    let clientPath: string = '';

    if (client) {
      const clientId = typeof client === 'number' ? client : client.id;
      clientPath = `/clients/${clientId}`
    }

    let url = `${environment.apiUrl}/api${clientPath}/projects?`;

    if (pageId) url += `&page=${pageId}`;
    if (step != null) url += `&step=${step}`;
    if (range) {
      if (range[0]) url += `&minDate=${range[0]}`;
      if (range[1]) url += `&maxDate=${range[1]}`;
    }

    return this.http.get<PaginatedProject>(url, HTTP_OPTIONS);
  }

  getClientProjects(client: number | Client): Observable<Project[]> {
    const clientId = typeof client === 'number' ? client : client.id;
    const url = `${environment.apiUrl}/api/clients/${clientId}/projects`;
    return this.http.get<Project[]>(url, HTTP_OPTIONS);
  }

  getProject(projectId: number): Observable<Project> {
    const url = `${environment.apiUrl}/api/projects/${projectId}`;
    return this.http.get<Project>(url, HTTP_OPTIONS);
  }

  addProject() {
    // TODO
  }

  updateProject() {
    // TODO
  }

  udpateProjectStep() {
    // TODO
  }

  updateProjectPayment() {
    // TODO
  }

  destroyProject() {
    // TODO
  }
}
