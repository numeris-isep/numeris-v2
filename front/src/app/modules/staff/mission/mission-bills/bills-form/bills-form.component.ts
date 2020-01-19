import { Component, Input, OnInit } from '@angular/core';
import { Application } from '../../../../../core/classes/models/application';
import { Mission } from '../../../../../core/classes/models/mission';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Rate } from '../../../../../core/classes/models/rate';
import { Bill } from '../../../../../core/classes/models/bill';
import { MissionService } from '../../../../../core/http/mission.service';
import { first } from 'rxjs/operators';
import { handleFormErrors } from '../../../../../core/functions/form-error-handler';
import { Router } from '@angular/router';
import { ApplicationService } from '../../../../../core/http/application.service';
import { ApplicationHandlerService } from '../../../../../core/services/handlers/application-handler.service';

@Component({
  selector: 'app-bills-form',
  templateUrl: './bills-form.component.html'
})
export class BillsFormComponent implements OnInit {

  @Input() mission: Mission;
  applications: Application[];

  billsForm: FormGroup;
  initialValue: object;
  applicationsFormArray: FormArray;
  loading  = false;
  submitted = false;

  constructor(
    private router: Router,
    private missionService: MissionService,
    private applicationService: ApplicationService,
    private applicationHandler: ApplicationHandlerService,
    private fb: FormBuilder,
  ) { }

  ngOnInit() {
    this.applicationsFormArray = this.fb.array([]);
    this.getApplications();
  }

  getApplications() {
    this.applicationHandler.getApplications('accepted').subscribe(applications => {
      this.applications = applications;

      this.initApplicationsForm();
      this.billsForm = this.fb.group({
        applications: this.applicationsFormArray
      });

      this.initialValue = this.billsForm.value;
    });
  }

  get f() { return this.billsForm.controls; }

  get fa() { return this.billsForm.get('applications') as FormArray; }

  fag(index: number, control: string) {
    const fa: FormGroup = this.fa.controls[index] as FormGroup;
    return fa.controls[control] as FormGroup;
  }

  fbg(indexA: number, indexB: number, control: string) {
    const fb: FormGroup = this.fag(indexA, 'bills') as FormGroup;
    const fbg: FormGroup = fb.controls[indexB] as FormGroup;
    return fbg.controls[control];
  }

  initApplicationsForm() {
    this.applicationsFormArray = this.fb.array([]);

    for (const application of this.applications) {
      this.addApplication(application);
    }
  }

  createApplication(
    application: Application
  ) {
    return this.fb.group({
      application_id: [application.id],
      user_id: [application.user.id],
      user_name: [`${application.user.firstName} ${application.user.lastName.toUpperCase()}`],
      bills: this.initBillsForm(application.bills),
    });
  }

  initBillsForm(bills: Bill[]) {
    const billsFormArray = this.fb.array([]);

    for (const rate of this.mission.project.convention.rates) {
      const bill = bills.filter(b => b.rateId === rate.id)[0];
      billsFormArray.push(this.createBill(rate, bill));
    }

    return billsFormArray;
  }

  addApplication(application: Application) {
    this.applicationsFormArray.push(this.createApplication(application));
  }

  createBill(rate: Rate, bill: Bill = null) {
    return this.fb.group({
      id: [bill ? bill.id : null],
      rate_id: [rate.id, Validators.required],
      amount: [bill ? bill.amount : 0.00, Validators.required],
    });
  }

  onSubmit() {
    if (['hiring', 'validated'].includes(this.mission.project.step)) {
      this.submitted = true;
      this.loading = true;

      this.missionService.updateMissionBills(this.billsForm.value, this.mission).pipe(first())
        .subscribe(
          () => {
            this.applicationHandler.setApplications(this.billsForm.value.applications);
            // this.ngOnInit();
            this.loading = false;
          },
          errors => {
            for (let i = 0; i < this.applications.length; i++) {
              for (let j = 0; j < this.mission.project.convention.rates.length; j++) {
                handleFormErrors(this.fbg(i, j, 'amount') as FormGroup, errors);
              }
            }
            this.loading = false;
          }
        );
    }
  }

}
