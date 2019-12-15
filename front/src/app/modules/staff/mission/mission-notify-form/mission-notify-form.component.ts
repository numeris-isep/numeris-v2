import { Component, Input, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Mission } from '../../../../core/classes/models/mission';
import { AlertService } from '../../../../core/services/alert.service';
import { MissionService } from '../../../../core/http/mission.service';
import * as moment from 'moment';
import { Router } from '@angular/router';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';

@Component({
  selector: 'app-mission-notify-form',
  templateUrl: './mission-notify-form.component.html'
})
export class MissionNotifyFormComponent implements OnInit {

  @Input() missions: Mission[];

  missionForm: FormGroup = this.fb.group({});
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private missionService: MissionService,
    private fb: FormBuilder,
    private router: Router,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.initForm();
  }

  initForm() {
    const missionsFormArray: FormArray = this.fb.array([]);

    this.missions.forEach(mission => missionsFormArray.push(this.addMission(mission)));

    this.missionForm = this.fb.group({
      missions: missionsFormArray
    });
  }

  addMission(mission: Mission) {
    return this.fb.group({
      id: [mission.id, Validators.required],
      title: [mission.title, Validators.required],
      startAt: [moment(mission.startAt).format('DD/MM/Y HH:mm'), Validators.required],
      checked: [false, Validators.required],
    });
  }

  get f() { return this.missionForm.controls; }

  get fm() { return this.missionForm.get('missions') as FormArray; }

  fmg(index: number) { return this.fm.controls[index] as FormGroup; }

  onSubmit() {
    this.submitted = true;

    if (this.missionForm.invalid) { return; }

    this.loading = true;

    const data: number[] = this.getFormData();

    this.missionService.notifyAvailability(data).subscribe(
      () => {
        this.loading = false;
        this.router.navigate(['/missions']);
        this.alertService.success(['L\'email a bien été envoyé.']);
      },
      errors => {
        handleFormErrors(this.missionForm, errors);
        this.loading = false;
      }
    );

  }

  getFormData(): number[] {
    return this.missionForm.value.missions
      .filter(mission => mission.checked)
      .map(mission => mission.id);
  }

}
