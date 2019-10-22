import { Component, OnInit, ViewChild } from '@angular/core';
import { Observable } from 'rxjs';
import { AuthService } from '../../http/auth/auth.service';
import { ScrollService } from '../../services/scroll.service';
import { ScrollDirective } from '../../../shared/directives/scroll.directive';
import { MissionService } from '../../http/mission.service';
import { Count } from '../../classes/count';
import { logger } from 'codelyzer/util/logger';
import { Mission } from '../../classes/models/mission';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.scss']
})
export class SidebarComponent implements OnInit {

  isLoggedIn$: Observable<boolean>;

  @ViewChild(ScrollDirective) scroll: ScrollDirective;

  counts: Count;

  constructor(
    private authService: AuthService,
    private missionService: MissionService,
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

  getCounts(isOpening: boolean) {
    this.isLoggedIn$.subscribe(value => {
      if (value && isOpening) {
        this.missionService.getAvailableMissions().subscribe(missions => {
          this.counts = {
            missions: missions.length,
            applications: this.getApplicationsCount(missions),
          };
        });
      }
    });
  }

  private getApplicationsCount(missions: Mission[]): number {
    return missions.filter(mission => (
      mission.applications.length > 0
      && mission.applications
        .filter(application => (
          application.userId === this.authService.getCurrentUserId()
          && application.status === 'accepted'
        )).length > 0
    )).length;
  }

  // This is to avoid red underlining from the IDE
  open(): void {}
  close(): void {}
  toggle(): void {}
}
