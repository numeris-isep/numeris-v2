import { Injectable } from '@angular/core';
import { Title } from "@angular/platform-browser";
import { Observable, Subject } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class TitleService {

  private headerTitle$: Subject<string> = new Subject<string>();

  constructor(private titleService: Title) { }

  setTabTitle(title: string) {
    this.titleService.setTitle(title);
  }

  getTabTitle(): string {
    return this.titleService.getTitle();
  }

  setHeaderTitle(headerTitle: string) {
    this.headerTitle$.next(headerTitle);
  }

  getHeaderTitle(): Observable<string> {
    return this.headerTitle$.asObservable();
  }
}
