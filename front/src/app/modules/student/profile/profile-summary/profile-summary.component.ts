import { Component, Input, OnInit } from '@angular/core';
import { User } from "../../../../core/classes/models/user";
import { AuthService } from "../../../../core/http/auth/auth.service";

@Component({
  selector: 'app-profile-summary',
  templateUrl: './profile-summary.component.html'
})
export class ProfileSummaryComponent implements OnInit {

  @Input() user: User;
  currentUserRole: string;

  constructor(private authService: AuthService) { }

  ngOnInit() {
    this.currentUserRole = this.authService.getCurrentUserRole();
  }

}
