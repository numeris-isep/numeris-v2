import * as jsPDF from 'jspdf';
import { ElementRef } from '@angular/core';

export class File {

  name: string;
  html: ElementRef;

  constructor(file: File) {
    Object.assign(this, file);
  }

  get buildPdf(): jsPDF {
    const pdf = new jsPDF();
    pdf.fromHTML(this.html.nativeElement, 0, 0);

    return pdf;
  }

  download() {
    this.buildPdf.save(this.name);
  }

}
