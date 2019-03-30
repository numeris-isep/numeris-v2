import { Injectable } from '@angular/core';
import { Title } from "@angular/platform-browser";
import { BehaviorSubject, Observable, Subject } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class TitleService {

  baseTitle: string = 'Numéris ISEP';
  separator: string = ' - ';

  private headerTitle: BehaviorSubject<string> = new BehaviorSubject<string>(null);

  constructor(private titleService: Title) { }

  setTabTitle(title: string) {
    let finalTitle = this.baseTitle;
    if (title != null) {
      finalTitle += this.separator + title;
    }

    this.titleService.setTitle(finalTitle);
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

  setTitles(title: string) {
    this.setHeaderTitle(title);
    this.setTabTitle(title);
  }
}
