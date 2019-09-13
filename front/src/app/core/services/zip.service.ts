import { Injectable } from '@angular/core';
import { Zip } from '../classes/zip';
import { File } from '../classes/file';

@Injectable({
  providedIn: 'root'
})
export class ZipService {

  constructor() { }

  download(files: File[], zipName: string = 'archive.zip') {
    const zip = new Zip({name: zipName, files: files} as Zip);
    zip.download();
  }
}
