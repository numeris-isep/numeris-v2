import { Injectable } from '@angular/core';
import { ApplicationService } from '../../http/application.service';
import { BehaviorSubject } from 'rxjs';
import { Application } from '../../classes/models/application';
import { Mission } from '../../classes/models/mission';

@Injectable({
  providedIn: 'root'
})
export class ApplicationHandlerService {

  private applications: BehaviorSubject<Application[]> = new BehaviorSubject<Application[]>([]);
  private waitingApplications: BehaviorSubject<Application[]> = new BehaviorSubject<Application[]>([]);
  private acceptedApplications: BehaviorSubject<Application[]> = new BehaviorSubject<Application[]>([]);
  private refusedApplications: BehaviorSubject<Application[]> = new BehaviorSubject<Application[]>([]);

  constructor(private applicationService: ApplicationService) { }

  getApplications(status?: string) {
    switch (status) {
      case 'waiting': return this.waitingApplications;
      case 'accepted': return this.acceptedApplications;
      case 'refused': return this.refusedApplications;
      default: return this.applications;
    }
  }

  watchApplications(mission: Mission) {
    this.applicationService.getMissionApplications(mission)
      .subscribe(applications => {
        this.applications.next(applications);
        applications
          .map(application => {
            switch (application.status) {
              case 'waiting':
                this.waitingApplications.next([...this.waitingApplications.getValue(), application]);
                break;
              case 'accepted':
                this.acceptedApplications.next([...this.acceptedApplications.getValue(), application]);
                break;
              case 'refused':
                this.refusedApplications.next([...this.refusedApplications.getValue(), application]);
                break;
              default: break;
            }
          });
      });
  }

  setApplication(newStatus: string, application: Application) {
    // Remove application from old list
    if (newStatus !== application.status) {
      switch (application.status) {
        case 'waiting':
          this.waitingApplications.next([...this.waitingApplications.getValue()].filter(a => a !== application));
          break;
        case 'accepted':
          this.acceptedApplications.next([...this.acceptedApplications.getValue()].filter(a => a !== application));
          break;
        case 'refused':
          this.refusedApplications.next([...this.refusedApplications.getValue()].filter(a => a !== application));
          break;
        default: break;
      }

      this.applications.next([...this.applications.getValue()].filter(a => a !== application));
    }

    // Add application to new list
    switch (newStatus) {
      case 'waiting':
        this.waitingApplications.next([...this.waitingApplications.getValue(), application]);
        break;
      case 'accepted':
        this.acceptedApplications.next([...this.acceptedApplications.getValue(), application]);
        break;
      case 'refused':
        this.refusedApplications.next([...this.refusedApplications.getValue(), application]);
        break;
      default: break;
    }

    this.applications.next([...this.applications.getValue(), application]);

    application.status = newStatus; // Set new status
  }

  resetAll() {
    this.applications.unsubscribe();
    this.waitingApplications.unsubscribe();
    this.acceptedApplications.unsubscribe();
    this.refusedApplications.unsubscribe();

    this.applications = new BehaviorSubject<Application[]>([]);
    this.waitingApplications = new BehaviorSubject<Application[]>([]);
    this.acceptedApplications = new BehaviorSubject<Application[]>([]);
    this.refusedApplications = new BehaviorSubject<Application[]>([]);
  }
}
