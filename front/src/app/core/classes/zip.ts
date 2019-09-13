import { File } from './file';
import * as jsZIP from 'jszip';
import * as FileSaver from 'file-saver';

export class Zip {

  name: string;
  files: File[] = [];

  constructor(zip: Zip) {
    Object.assign(this, zip);
  }

  download() {
    const zip = new jsZIP();

    this.files.forEach(file => zip.file(file.name, file.buildPdf.output()));
    zip.generateAsync({type: 'blob'})
      .then((zip) => FileSaver.saveAs(zip, this.name));
  }
}
