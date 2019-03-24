import { Component, Input, OnInit } from '@angular/core';
import { Preference } from "../../../../core/classes/models/preference";
import { PreferenceService } from "../../../../core/http/preference.service";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { AlertService } from "../../../../core/services/alert.service";
import { Router } from "@angular/router";

@Component({
  selector: 'app-profile-preferences',
  templateUrl: './profile-preferences.component.html'
})
export class ProfilePreferencesComponent implements OnInit {

  @Input() preference: Preference;

  preferenceForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private preferenceService: PreferenceService,
    private formBuilder: FormBuilder,
    private alertService: AlertService,
    private router: Router
  ) { }

  ngOnInit() {
    this.preferenceForm  = this.formBuilder.group({
      on_new_mission: [this.preference.onNewMission || false, Validators.required],
      on_acceptance:  [this.preference.onAcceptance || false, Validators.required],
      on_refusal:     [this.preference.onRefusal || false, Validators.required],
      on_document:    [this.preference.onDocument || false, Validators.required],
      by_email:       [this.preference.byEmail || false, Validators.required],
      by_push:        [this.preference.byPush || false, Validators.required],
    });
  }

  updatePreference() {
    this.submitted = true;

    // stop here if form is invalid
    if (this.preferenceForm.invalid) { return; }

    this.loading = true;

    this.preferenceService.updatePreference({
      id: this.preference.id,
      ...this.preferenceForm.value
    }).subscribe(_ => {
        this.router.navigate(['/'])
          .then(() => { this.router.navigate(['/profile']) } );
        this.alertService.success('Préférences de notifications mises à jour.', null, true);
      },
      error => {
        this.loading = false;
      });
  }

}
