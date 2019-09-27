import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';
import { HttpClient } from '@angular/common/http';
import { HTTP_OPTIONS } from '../constants/http_options';

@Injectable({
  providedIn: 'root'
})
export class FileService {

  constructor(private http: HttpClient) { }

  getPayslip(payslipId: number): Observable<any> {
    const url = `${environment.apiUrl}/api/payslips/${payslipId}/download-payslip`;
    return this.http.get(url, { responseType: 'blob' });
  }

  getContract(payslipId: number): Observable<any> {
    const url = `${environment.apiUrl}/api/payslips/${payslipId}/download-contract`;
    return this.http.get(url, { responseType: 'blob' });
  }

  getInvoice(invoiceId: number): Observable<any> {
    const url = `${environment.apiUrl}/api/invoices/${invoiceId}/download`;
    return this.http.get(url, { responseType: 'blob' });
  }

  getFileURL(file: any, type: string = 'application/pdf'): string {
    const blob = new Blob([file], { type: type });
    return window.URL.createObjectURL(blob);
  }

  getArchive(month: string) {
    const url = `${environment.apiUrl}/api/payslips/download-zip`;
    return this.http.put(url, { month: month }, { responseType: 'blob' });
  }

  downloadFile(file: any, type) {
    window.open(this.getFileURL(file, type));
  }
}
