import { Injectable } from '@angular/core';
import { Title } from "@angular/platform-browser";
import { BehaviorSubject, Observable, Subject } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class TitleService {

  private headerTitle: BehaviorSubject<string> = new BehaviorSubject<string>(null);

  constructor(private titleService: Title) { }

  setTabTitle(title: string) {
    this.titleService.setTitle(title);
  }

  getTabTitle(): string {
    return this.titleService.getTitle();
  }

  setHeaderTitle(headerTitle: string) {
    this.headerTitle.next(headerTitle);
  }

  getHeaderTitle(): Observable<string> {
    return this.headerTitle.asObservable();
  }
}
