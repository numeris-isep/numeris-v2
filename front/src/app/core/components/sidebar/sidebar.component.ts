import { Component, OnInit, ViewChild } from '@angular/core';
import { Observable } from 'rxjs';
import { AuthService } from '../../http/auth/auth.service';
import { ScrollService } from '../../services/scroll.service';
import { ScrollDirective } from '../../../shared/directives/scroll.directive';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.scss']
})
export class SidebarComponent implements OnInit {

  isLoggedIn$: Observable<boolean>;

  @ViewChild(ScrollDirective) scroll: ScrollDirective;

  constructor(
    private authService: AuthService,
    private scrollService: ScrollService
  ) { }

  ngOnInit() {
    this.isLoggedIn$ = this.authService.isLoggedIn;
  }

  scrollPosition(event) {
    this.scrollService.setScrollPosition(event);
  }

  scrollToElement(anchor: string) {
    this.scrollService.scrollToElement(anchor);
  }

  // This is to avoid red underlining from the IDE
  open(): void {}
  close(): void {}
  toggle(): void {}
}
