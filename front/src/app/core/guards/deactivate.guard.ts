import { Injectable } from '@angular/core';
import { CanDeactivate } from '@angular/router';
import { Observable } from 'rxjs';
import { DialogService } from '../services/dialog.service';

export interface CanComponentDeactivate {
  canDeactivate: () => Observable<boolean> | Promise<boolean> | boolean;
}

@Injectable({
  providedIn: 'root'
})
export class DeactivateGuard implements CanDeactivate<CanComponentDeactivate>  {

  constructor(private dialogService: DialogService) {}

  canDeactivate(component: CanComponentDeactivate): Observable<boolean> | Promise<boolean> | boolean {
    return component.canDeactivate ? (! component.canDeactivate() ? this.dialogService.confirm() : true) : true;
  }

}
