import { Component, HostListener, Input, OnInit } from '@angular/core';
import { PaginatedMission } from "../../../../core/classes/pagination/paginated-mission";
import { MissionService } from "../../../../core/http/mission.service";
import * as moment from "moment";
import { IPopup } from "ng2-semantic-ui";
import { Project } from "../../../../core/classes/models/project";

@Component({
  selector: 'app-mission-list',
  templateUrl: './mission-list.component.html',
  styleUrls: [
    './mission-list.component.scss',
    '../../project/project.component.css',
    '../../client/client-convention/client-convention.component.css'
  ]
})
export class MissionListComponent implements OnInit {

  @HostListener('window:resize', ['$event'])
  onResize(event) {
    this.windowWidth = event.target.innerWidth;
  }

  windowWidth: number = window.innerWidth;

  @Input() project: Project = null;
  paginatedMission: PaginatedMission;
  selectedOption: string;
  from: string;
  to: string;
  loading: boolean = false;
  options = ["Missions ouvertes", "Missions fermées"];

  constructor(private missionService: MissionService) { }

  ngOnInit() {
    this.getMissionsPerPage(1);
  }

  reset(field: string) {
    if (this[field] !== undefined) this[field] = null;
    if (field == 'selectedOption') this.setFilter();
  }

  getMissionsPerPage(pageId?: number) {
    this.loading = true;
    this.missionService.getMissionsPerPage(
      this.project,
      pageId,
      this.selectedOptionToIsLocked(),
      [this.dateToISO(this.from), this.dateToISO(this.to)]
    ).subscribe(paginatedMission => {
      this.paginatedMission = paginatedMission;
      this.loading = false;
    });
  }

  setFilter() {
    if (this.selectedOption !== undefined
      || this.from !== undefined
      || this.to !== undefined
    ) {
      this.getMissionsPerPage(1);
    }
  }

  selectedOptionToIsLocked() {
    if (this.selectedOption !== undefined && this.selectedOption !== null) {
      return this.selectedOption != "Missions ouvertes"
    }
    return this.selectedOption;
  }

  dateToISO(date: string) {
    return date ? moment(date).toISOString() : null;
  }

  togglePopup(popup: IPopup, condition) {
    const widthCondition = this.windowWidth >= 1287
      || (this.windowWidth < 1200 && this.windowWidth > 1093);

    if (condition && widthCondition) {
      popup.toggle();
    }
  }

}
