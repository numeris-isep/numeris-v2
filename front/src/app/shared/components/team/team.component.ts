import { Component, OnInit } from '@angular/core';
import { TeamMember } from '../../../core/classes/team-member';
import { TEAM_MEMBERS} from '../../../core/constants/team_members';

@Component({
  selector: 'app-team',
  templateUrl: './team.component.html'
})
export class TeamComponent implements OnInit {

  teamMembers: TeamMember[] = TEAM_MEMBERS;

  constructor() { }

  ngOnInit() {
  }

}
