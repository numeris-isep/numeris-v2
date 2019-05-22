import { Component, Input, OnInit } from '@angular/core';
import { Application } from '../../../../../core/classes/models/application';
import { Mission } from '../../../../../core/classes/models/mission';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Rate } from '../../../../../core/classes/models/rate';
import { Bill } from '../../../../../core/classes/models/bill';
import { ApplicationService } from '../../../../../core/http/application.service';

@Component({
  selector: 'app-bills-form',
  templateUrl: './bills-form.component.html'
})
export class BillsFormComponent implements OnInit {

  @Input() mission: Mission;
  applications: Application[];

  billsForm: FormGroup;
  applicationsFormArray: FormArray = this.fb.array([]);
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private applicationService: ApplicationService,
    private fb: FormBuilder,
  ) { }

  ngOnInit() {
    this.getApplications().subscribe(applications => {
      this.applications = applications;

      this.initApplicationsForm();
      this.billsForm = this.fb.group({
        applications: this.applicationsFormArray
      });
    });
  }

  getApplications() {
    return this.applicationService.getMissionApplications(this.mission, 'accepted');
  }

  get f() { return this.billsForm.controls; }

  get fa() { return this.billsForm.get('applications') as FormArray; }

  fag(index: number, control: string) { return this.fa.controls[index].controls[control]; }

  fbg(indexA: number, indexB: number, control: string) {
    return this.fag(indexA, 'bills').controls[indexB].controls[control];
  }

  initApplicationsForm() {
    for (const application of this.applications) {
      this.addApplication(application);
    }
  }

  initBillsForm() {
    const billsFormArray = this.fb.array([]);

    for (const rate of this.mission.project.convention.rates) {
      billsFormArray.push(this.createBill(rate));
    }

    return billsFormArray;
  }

  createApplication(
    application: Application
  ) {
    return this.fb.group({
      application_id: [application.id],
      user_id: [application.user.id],
      user_name: [`${application.user.firstName} ${application.user.lastName.toUpperCase()}`],
      bills: this.initBillsForm(),
    });
  }

  addApplication(application: Application) {
    this.applicationsFormArray.push(this.createApplication(application));
  }

  createBill(rate: Rate, bill: Bill = null) {
    return this.fb.group({
      rate_id: [rate.id, Validators.required],
      amount: [bill ? bill.amount : Math.round(Math.random() * 10)],
    });
  }

  onSubmit() {
    this.submitted = true;

    if (this.billsForm.invalid) { return; }

    this.loading = true;
  }

}
