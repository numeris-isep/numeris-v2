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

  getUser(user_id: number): Observable<User> {
    const url = `${environment.apiUrl}/api/users/${user_id}`;
    return this.http.get<User>(url, HTTP_OPTIONS);
  }

  addUser() {
    // TODO
  }

  updateUser() {
    // TODO
  }

  destroyUser(id: number) {
    // TODO
  }
}
