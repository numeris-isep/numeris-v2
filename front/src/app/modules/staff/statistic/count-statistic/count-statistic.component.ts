import { Component, OnInit } from '@angular/core';
import { Count } from '../../../../core/classes/count';
import { forkJoin, Observable } from 'rxjs';
import { Project } from '../../../../core/classes/models/project';
import { Client } from '../../../../core/classes/models/client';
import { UserService } from '../../../../core/http/user.service';
import { MissionService } from '../../../../core/http/mission.service';
import { ProjectService } from '../../../../core/http/project.service';
import { ClientService } from '../../../../core/http/client.service';
import { PaginatedUser } from '../../../../core/classes/pagination/paginated-user';
import { PaginatedMission } from '../../../../core/classes/pagination/paginated-mission';

@Component({
  selector: 'app-count-statistic',
  templateUrl: './count-statistic.component.html'
})
export class CountStatisticComponent implements OnInit {

  counts: Count;

  userCount: any;
  missionCount: any;
  projectCount: any;
  clientCount: any;

  constructor(
    private userService: UserService,
    private missionService: MissionService,
    private projectService: ProjectService,
    private clientService: ClientService,
  ) { }

  ngOnInit() {
    this.initCounts();
    this.getCounts();
  }

  initCounts() {
    this.counts = {
      users: 0,
      missions: 0,
      projects: 0,
      clients: 0,
    };
  }

  getCounts() {
    forkJoin([
      this.getUsers(),
      this.getMissions(),
      this.getProjects(),
      this.getClients(),
    ]).subscribe(data => {
      this.counts = {
        users: data[0].meta.total,
        missions: data[1].meta.total,
        projects: data[2].length,
        clients: data[3].length,
      };
    });
  }

  getUsers(): Observable<PaginatedUser> {
    return this.userService.getUsers();
  }

  getMissions(): Observable<PaginatedMission> {
    return this.missionService.getMissions();
  }

  getProjects(): Observable<Project[]> {
    return this.projectService.getProjects();
  }

  getClients(): Observable<Client[]> {
    return this.clientService.getClients();
  }

}
