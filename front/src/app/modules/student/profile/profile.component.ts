import { Component, OnInit, ViewChild } from '@angular/core';
import { User } from '../../../core/classes/models/user';
import { AuthService } from '../../../core/http/auth/auth.service';
import { ProfilePreferencesComponent } from './profile-preferences/profile-preferences.component';
import { CanComponentDeactivate } from '../../../core/guards/deactivate.guard';
import { handleFormDeactivation } from '../../../core/functions/form-deactivate-handler';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit, CanComponentDeactivate {

  @ViewChild(ProfilePreferencesComponent) profilePreferenceComponent: ProfilePreferencesComponent;

  user: User;

  constructor(private authService: AuthService) { }

  ngOnInit() {
    this.getCurrentUser();
  }

  canDeactivate() {
    return handleFormDeactivation(this.profilePreferenceComponent, 'preferenceForm');
  }

  getCurrentUser() {
    this.authService.getCurrentUser().subscribe(user => this.user = user);
  }

}
