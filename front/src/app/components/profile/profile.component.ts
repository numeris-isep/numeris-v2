import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../services/auth.service";
import { User } from "../../models/user";

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html'
})
export class ProfileComponent implements OnInit {

  currentUser: User = new User();

  constructor(private authService: AuthService) { }

  ngOnInit() {
    this.authService.getCurrentUser()
      .subscribe((data: User) => this.currentUser = data);
  }

}
