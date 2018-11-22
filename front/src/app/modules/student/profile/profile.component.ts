import { Component, OnInit } from '@angular/core';
import { UsersService } from "../../../core/http/users.service";
import { User } from "../../../core/classes/models/user";

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {

  user: User;

  constructor(private usersService: UsersService) { }

  ngOnInit() {
    this.getUser(1);
  }

  getUser(id: number) {
    this.usersService.getUser(id).subscribe(user => this.user = user);
  }

}
