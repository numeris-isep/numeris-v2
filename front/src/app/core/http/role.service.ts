import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { environment } from "../../../environments/environment";
import { Observable } from "rxjs";
import { Role } from "../classes/models/role";
import { HTTP_OPTIONS } from "../constants/http_options";

@Injectable({
  providedIn: 'root'
})
export class RoleService {

  constructor(private http: HttpClient) { }

  getRoles(): Observable<Role[]> {
    const url = `${environment.apiUrl}/api/roles`;
    return this.http.get<Role[]>(url, HTTP_OPTIONS);
  }
}
