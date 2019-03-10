import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { User } from "../classes/models/user";
import { HTTP_OPTIONS } from "../constants/http_options";
import { environment } from "../../../environments/environment";

@Injectable({
  providedIn: 'root'
})
export class UsersService {

  constructor(private http: HttpClient) { }

  getUsers() {
    // TODO
  }

  getUser(id: number): Observable<User> {
    const url = `${environment.apiUrl}/api/users/${id}`;
    return this.http.get<User>(url, HTTP_OPTIONS);
  }

  addUser() {
    // TODO
  }

  updateUser() {
    // TODO
  }

  deleteUser(id: number) {
    // TODO
  }
}
