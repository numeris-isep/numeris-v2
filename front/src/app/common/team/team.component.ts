import { Component, OnInit } from '@angular/core';
import { TeamMember } from "../_classes/TeamMember";
import { TEAM_MEMBERS } from "../_constants/TEAM_MEMBERS";

@Component({
  selector: 'app-team',
  templateUrl: './team.component.html',
  styleUrls: ['./team.component.css']
})
export class TeamComponent implements OnInit {

  teamMembers: TeamMember[] = TEAM_MEMBERS;

  constructor() { }

  ngOnInit() {
  }

}
