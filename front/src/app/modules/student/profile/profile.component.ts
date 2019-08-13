import { Component, OnInit } from '@angular/core';
import { User } from '../../../core/classes/models/user';
import { AuthService } from '../../../core/http/auth/auth.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {

  user: User;

  constructor(private authService: AuthService) { }

  ngOnInit() {
    this.getCurrentUser();
  }

  getCurrentUser() {
    this.authService.getCurrentUser().subscribe(user => this.user = user);
  }

}
