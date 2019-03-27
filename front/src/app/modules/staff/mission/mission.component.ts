import { Component, OnInit } from '@angular/core';
import { MissionService } from 'src/app/core/http/mission.service';
import { PaginatedMission } from "../../../core/classes/pagination/paginated-mission";
import * as moment from 'moment';

@Component({
  selector: 'app-mission',
  templateUrl: './mission.component.html',
  styleUrls: ['./mission.component.css']
})
export class MissionComponent implements OnInit {

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
}
