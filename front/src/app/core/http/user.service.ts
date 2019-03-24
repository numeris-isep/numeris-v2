import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { User } from "../classes/models/user";
import { HTTP_OPTIONS } from "../constants/http_options";
import { environment } from "../../../environments/environment";

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private http: HttpClient) { }

  getUsers() {
    // TODO
  }

  getUser(user: User): Observable<User> {
    const url = `${environment.apiUrl}/api/users/${user.id}`;
    return this.http.get<User>(url, HTTP_OPTIONS);
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
