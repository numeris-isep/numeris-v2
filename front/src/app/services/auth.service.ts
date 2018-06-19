import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private baseUrl: string = 'http://localhost:8000/api';

  constructor(private http: HttpClient) { }

  login(data) {
    return this.http.post(`${this.baseUrl}/login`, data);
  }
}
