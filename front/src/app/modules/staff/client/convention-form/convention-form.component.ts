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

@Component({
  selector: 'app-convention-form',
  templateUrl: './convention-form.component.html',
  styleUrls: ['./convention-form.component.css'],
})
export class ConventionFormComponent implements OnInit {

  @Input() client: Client;
  @Input() convention: Convention;

  conventionForm: FormGroup;
  ratesFormArray: FormArray;
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private fb: FormBuilder,
    private conventionService: ConventionService,
    private alertService: AlertService,
    private router: Router,
  ) { }

  ngOnInit() {
    if (this.convention) {
      // Populate rates FormArray
    } else {
      this.ratesFormArray = this.fb.array([this.createRate()]);
    }

    this.conventionForm = this.fb.group({
      name: [
        this.convention ? this.convention.name : '',
        Validators.required,
      ],
      rates : this.ratesFormArray,
    });
  }

  get f() { return this.conventionForm.controls; }

  get fr() { return this.conventionForm.get('rates') as FormArray; }

  frg(index: number) { return this.fr.controls[index] as FormGroup; }

  createRate(
    name: string = '', for_student: string = '', for_staff: string = '',
    for_client: string = '', is_flat: boolean = false, hours: number = null,
  ) {
    return this.fb.group({
      id: [null], // for update: put the id of the rate
      name: [name, Validators.required],
      for_student: [for_student, Validators.required],
      for_staff: [for_staff, Validators.required],
      for_client: [for_client, Validators.required],
      is_flat: [is_flat],
      hours: [hours],
    });
  }

  addRate() {
    this.ratesFormArray.push(this.createRate());
  }

  removeRate(index: number) {
    this.ratesFormArray.removeAt(index);
  }

  onSubmit() {
    this.submitted = true;

    if (this.conventionForm.invalid) { return; }

    this.loading = true;
    let conventionRequest: Observable<Convention>;

    if (!this.convention) {
      conventionRequest = this.conventionService.addClientConvention(this.client, this.conventionForm.value as Convention);
    } else {
      // Update
    }

    conventionRequest.pipe(first())
      .subscribe(
        convention => {
          this.loading = false;
          if (!this.convention) {
            this.router.navigate([`/clients/${this.client.id}`]); // TODO: change to '/conventions'
            this.alertService.success([`La convention ${convention.name} a bien été créée.`]);
          } else {
            // Update
          }
        },
        errors => {
          handleFormErrors(this.conventionForm, errors);
          handleFormErrors(this.conventionForm.controls.rates as FormGroup, errors);
          this.loading = false;
        },
      );
  }

}
