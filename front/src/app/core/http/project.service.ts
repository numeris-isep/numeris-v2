import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { environment } from "../../../environments/environment";
import { Observable } from "rxjs";
import { PaginatedProject } from "../classes/pagination/paginated-project";
import { HTTP_OPTIONS } from "../constants/http_options";

@Injectable({
  providedIn: 'root'
})
export class ProjectService {

  constructor(private http: HttpClient) { }

  getProjects(): Observable<PaginatedProject> {
    const url = `${environment.apiUrl}/api/projects`;
    return this.http.get<PaginatedProject>(url, HTTP_OPTIONS);
  }

  getProjectsPerPage(pageId?: number, step?: any, range?: [string, string]): Observable<PaginatedProject> {
    let url = `${environment.apiUrl}/api/projects?`;

    if (pageId) url += `&page=${pageId}`;
    if (step != null) url += `&step=${step}`;
    if (range) {
      if (range[0]) url += `&minDate=${range[0]}`;
      if (range[1]) url += `&maxDate=${range[1]}`;
    }

    return this.http.get<PaginatedProject>(url, HTTP_OPTIONS);
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
