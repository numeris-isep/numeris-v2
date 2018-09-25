import { Component, OnInit } from '@angular/core';
import { TeamMember } from "../_classes/team-member";
import { Team_members } from "../_constants/team_members";

@Component({
  selector: 'app-team',
  templateUrl: './team.component.html',
  styleUrls: ['./team.component.css']
})
export class TeamComponent implements OnInit {

  teamMembers: TeamMember[] = Team_members;

  constructor() { }

  ngOnInit() {
  }

}
