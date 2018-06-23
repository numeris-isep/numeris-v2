import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private http: HttpClient) { }

  getUsers() {
    // TODO
  }

  getUser(id: number) {
    // TODO
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
