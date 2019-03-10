import { Component, Input, OnInit } from '@angular/core';
import { Preference } from "../../../../core/classes/models/preference";

@Component({
  selector: 'app-profile-preferences',
  templateUrl: './profile-preferences.component.html'
})
export class ProfilePreferencesComponent implements OnInit {

  @Input() preference: Preference;

  constructor() { }

  ngOnInit() {
  }

}
