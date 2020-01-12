import { AfterViewInit, Component, Input, OnInit } from '@angular/core';
import { PreferenceService } from '../../../../core/http/preference.service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AlertService } from '../../../../core/services/alert.service';
import { equals } from '../../../../shared/utils';
import { User } from '../../../../core/classes/models/user';

@Component({
  selector: 'app-profile-preferences',
  templateUrl: './profile-preferences.component.html'
})
export class ProfilePreferencesComponent implements OnInit, AfterViewInit {

  @Input() user: User;

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
      on_new_mission: [this.user.preference.onNewMission || false, Validators.required],
      on_acceptance:  [this.user.preference.onAcceptance || false, Validators.required],
      on_refusal:     [this.user.preference.onRefusal || false, Validators.required],
      on_document:    [this.user.preference.onDocument || false, Validators.required],
    });
  }

  isDisabled() {
    if (this.initialValue) {
      return equals(this.initialValue, this.preferenceForm.value) || this.user.deletedAt;
    }

    return true;
  }

  updatePreference() {
    if (this.user.deletedAt) { return; }

    this.submitted = true;

    // stop here if form is invalid
    if (this.preferenceForm.invalid) { return; }

    this.loading = true;

    this.preferenceService.updatePreference({
      id: this.user.preference.id,
      ...this.preferenceForm.value
    }).subscribe(preference => {
      Object.assign(this.user.preference, preference);
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
