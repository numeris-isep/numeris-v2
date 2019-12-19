import { AfterViewInit, Component, Input, OnInit } from '@angular/core';
import { Preference } from '../../../../core/classes/models/preference';
import { PreferenceService } from '../../../../core/http/preference.service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AlertService } from '../../../../core/services/alert.service';
import { equals } from '../../../../shared/utils';

@Component({
  selector: 'app-profile-preferences',
  templateUrl: './profile-preferences.component.html'
})
export class ProfilePreferencesComponent implements OnInit, AfterViewInit {

  @Input() preference: Preference;

  preferenceForm: FormGroup;
  initialValue: object;
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private preferenceService: PreferenceService,
    private formBuilder: FormBuilder,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.initForm();
  }

  ngAfterViewInit() {
    this.initialValue = this.preferenceForm.value;
  }

  initForm() {
    this.preferenceForm  = this.formBuilder.group({
      on_new_mission: [this.preference.onNewMission || false, Validators.required],
      on_acceptance:  [this.preference.onAcceptance || false, Validators.required],
      on_refusal:     [this.preference.onRefusal || false, Validators.required],
      on_document:    [this.preference.onDocument || false, Validators.required],
    });
  }

  isDisabled() {
    if (this.initialValue) {
      return equals(this.initialValue, this.preferenceForm.value);
    }

    return true;
  }

  updatePreference() {
    this.submitted = true;

    // stop here if form is invalid
    if (this.preferenceForm.invalid) { return; }

    this.loading = true;

    this.preferenceService.updatePreference({
      id: this.preference.id,
      ...this.preferenceForm.value
    }).subscribe(preference => {
      Object.assign(this.preference, preference);
      this.initialValue = this.preferenceForm.value;
      this.initForm();
      this.alertService.success(['Préférences de notifications mises à jour.'], null, false);
      this.loading = false;
    },
    error => {
      this.loading = false;
    });
  }

}
