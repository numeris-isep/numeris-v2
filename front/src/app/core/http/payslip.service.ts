import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../../environments/environment';
import { HTTP_OPTIONS } from '../constants/http_options';
import { Observable } from 'rxjs';
import { Payslip } from '../classes/models/payslip';

@Injectable({
  providedIn: 'root'
})
export class PayslipService {

  constructor(private http: HttpClient) { }

  getPayslips(year: string): Observable<Payslip[]> {
    const url = `${environment.apiUrl}/api/payslips`;
    return this.http.post<Payslip[]>(url, {year: year}, HTTP_OPTIONS);
  }

  getPodium(month: string): Observable<Payslip[]> {
    const url = `${environment.apiUrl}/api/payslips-podium`;
    return this.http.put<Payslip[]>(url, {month: month}, HTTP_OPTIONS);
  }

  updatePayslips(month: string): Observable<Payslip[]> {
    const url = `${environment.apiUrl}/api/payslips`;
    return this.http.put<Payslip[]>(url, {month: month}, HTTP_OPTIONS);
  }

  updatePayslipsPartially(data: { id: number, signed?: boolean, paid?: boolean }[]): Observable<Payslip[]> {
    const url = `${environment.apiUrl}/api/payslips`;
    return this.http.patch<Payslip[]>(url, { payslips: data }, HTTP_OPTIONS);
  }
}
