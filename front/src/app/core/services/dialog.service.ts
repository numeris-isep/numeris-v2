import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class DialogService {

  constructor() { }

  confirm(message?: string): Observable<boolean> {
    const confirmation = window.confirm(message || 'Quitter sans enregistrer ?');

    return of(confirmation);
  }
}
