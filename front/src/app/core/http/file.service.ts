import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';
import { HttpClient } from '@angular/common/http';

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

  openFile(file: any, type: string = 'application/pdf') {
    const pwa = window.open(this.getFileURL(file, type));

    if (! pwa || pwa.closed || typeof pwa.closed === undefined) {
      alert('Pour ouvrir ce document, veuillez désactiver votre bloquer de publicité et réessayer.');
    }
  }
}
