import { Component, Input, OnInit } from '@angular/core';
import { Convention } from '../../../../core/classes/models/convention';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AlertService } from '../../../../core/services/alert.service';
import { Router } from '@angular/router';
import { ConventionService } from '../../../../core/http/convention.service';
import { Client } from '../../../../core/classes/models/client';
import { Observable } from 'rxjs';
import { first } from 'rxjs/operators';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';
import { Rate } from '../../../../core/classes/models/rate';

@Component({
  selector: 'app-convention-form',
  templateUrl: './convention-form.component.html',
  styleUrls: ['./convention-form.component.css'],
})
export class ConventionFormComponent implements OnInit {

  @Input() client: Client;
  @Input() convention: Convention;

  conventionForm: FormGroup;
  ratesFormArray: FormArray = this.fb.array([]);
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private fb: FormBuilder,
    private conventionService: ConventionService,
    private alertService: AlertService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.conventionForm = this.fb.group({
      name: [
        this.convention ? this.convention.name : '',
        Validators.required,
      ],
      rates : this.ratesFormArray,
    });

    if (this.convention) {
      for (let rate of this.convention.rates) {
        this.addRate(rate);
      }
    } else {
      this.addRate();
    }
  }

  get f() { return this.conventionForm.controls; }

  get fr() { return this.conventionForm.get('rates') as FormArray; }

  frg(index: number) { return this.fr.controls[index] as FormGroup; }

  createRate(rate: Rate = null) {
    return this.fb.group({
      id: [rate ? rate.id : null],
      name: [rate ? rate.name : '', Validators.required],
      for_student: [rate ? rate.forStudent : '', Validators.required],
      for_staff: [rate ? rate.forStaff : '', Validators.required],
      for_client: [rate ? rate.forClient : '', Validators.required],
      is_flat: [rate ? rate.isFlat : false],
      hours: [rate ? rate.hours : null],
    });
  }

  addRate(rate: Rate = null) {
    this.ratesFormArray.push(this.createRate(rate));
  }

  removeRate(index: number) {
    this.ratesFormArray.removeAt(index);
  }

  onSubmit() {
    this.submitted = true;

    if (this.conventionForm.invalid) { return; }

    this.loading = true;
    let conventionRequest: Observable<Convention>;

    this.conventionForm.value.rates.map(rate => {
      if (!rate.is_flat && rate.hours) { rate.hours = null; } // Remove hours when rate is flat
      return rate;
    });

    if (!this.convention) {
      conventionRequest = this.conventionService.addClientConvention(this.client, this.conventionForm.value as Convention);
    } else {
      conventionRequest = this.conventionService.updateConvention(this.convention, this.conventionForm.value as Convention);
    }

    conventionRequest.pipe(first())
      .subscribe(
        convention => {
          this.loading = false;
          this.router.navigate([`/clients/${this.client.id}/conventions`]);
          if (this.convention) { this.alertService.success([`La convention ${convention.name} a bien été modifiée.`]); }
        },
        errors => {
          handleFormErrors(this.conventionForm, errors);
          handleFormErrors(this.conventionForm.controls.rates as FormGroup, errors);
          this.loading = false;
        },
      );
  }

}
