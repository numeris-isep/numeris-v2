import { Component, Input, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { Payslip } from '../../../core/classes/models/payslip';
import { Invoice } from '../../../core/classes/models/Invoice';
import { FileService } from '../../../core/http/file.service';
import { AlertService } from '../../../core/services/alert.service';
import { Project } from '../../../core/classes/models/project';

@Component({
  selector: 'app-file',
  templateUrl: './file.component.html',
  styleUrls: ['./file.component.css']
})
export class FileComponent implements OnInit, OnChanges {

  @Input() type: string;
  @Input() data: Payslip | Invoice;
  @Input() otherData: Project;

  document: any;
  url: string;
  loading: boolean = false;

  constructor(
    private fileService: FileService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.initInvoice();
  }

  ngOnChanges(changes: SimpleChanges) {
    this.url = undefined;
  }

  initInvoice() {
    if (this.otherData) {
      Object.assign(this.data, { project: this.otherData });
    }
  }

  getDocument(documentId: number) {
    this.loading = true;

    switch (this.type) {
      case 'payslip':
        this.getPayslip(documentId);
        break;
      case 'contract':
        this.getContract(documentId);
        break;
      case 'invoice':
        this.getInvoice(documentId);
        break;
      default: break;
    }

    this.generateUrl();
  }

  generateUrl() {
    this.document.subscribe(
      file => {
        this.url = this.fileService.getFileURL(file);
        this.loading = false;
      },
      error => {
        this.alertService.error(['Erreur'], 'Le document n\'a pas pu être généré.');
        this.loading = false;
      }
    );
  }

  getPayslip(payslipId: number) {
    this.document = this.fileService.getPayslip(payslipId);
  }

  getContract(contractId: number) {
    this.document = this.fileService.getContract(contractId);
  }

  getInvoice(invoiceId: number) {
    this.document = this.fileService.getInvoice(invoiceId);
  }

}
