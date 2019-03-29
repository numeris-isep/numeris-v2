import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { User } from "../classes/models/user";
import { HTTP_OPTIONS } from "../constants/http_options";
import { environment } from "../../../environments/environment";
import { PaginatedUser } from "../classes/pagination/paginated-user";

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private http: HttpClient) { }

  getUsers(): Observable<PaginatedUser> {
    const url = `${environment.apiUrl}/api/users`;
    return this.http.get<PaginatedUser>(url, HTTP_OPTIONS);
  }

  getUsersPerPage(pageId?: number, search?: string, role?: string, promotion?: string): Observable<PaginatedUser> {
    let url = `${environment.apiUrl}/api/users?`;

    if (pageId) url += `&page=${pageId}`;
    if (search) url += `&search=${search}`;
    if (role != null) url += `&role=${role}`;
    if (promotion != null) url += `&promotion=${promotion}`;

    console.log(url);

    return this.http.get<PaginatedUser>(url, HTTP_OPTIONS);
  }

  getUser(user: User): Observable<User> {
    const url = `${environment.apiUrl}/api/users/${user.id}`;
    return this.http.get<User>(url, HTTP_OPTIONS);
  }

  getPromotions(): Observable<string[]> {
    const url = `${environment.apiUrl}/api/users-promotion`;
    return this.http.get<string[]>(url, HTTP_OPTIONS);
  }

  addUser() {
    // TODO
  }

  updateUser() {
    // TODO
  }

  updateUserTermsOfUse(user: User) {
    const url = `${environment.apiUrl}/api/users/${user.id}/terms-of-use`;
    return this.http.patch(url, { tou_accepted: true }, HTTP_OPTIONS);
  }

  destroyUser(user: User) {
    // TODO
  }
}
