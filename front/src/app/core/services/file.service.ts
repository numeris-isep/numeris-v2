import { ElementRef, Injectable } from '@angular/core';
import { File } from '../classes/file';

@Injectable({
  providedIn: 'root'
})
export class FileService {

  constructor() { }

  download(html: ElementRef, fileName: string = 'fichier.zip') {
    const file = new File({name: fileName, html: html} as File);
    file.download();
  }
}
