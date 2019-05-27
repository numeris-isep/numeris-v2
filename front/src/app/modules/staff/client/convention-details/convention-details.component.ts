import { Component, Input, OnInit } from '@angular/core';
import { Client } from '../../../../core/classes/models/client';
import { Convention } from '../../../../core/classes/models/convention';
import { ConventionDeleteModal } from '../convention-delete-modal/convention-delete-modal.component';
import { SuiModalService } from 'ng2-semantic-ui';
import { Mission } from '../../../../core/classes/models/mission';
import { MissionService } from '../../../../core/http/mission.service';
import { first } from 'rxjs/operators';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ApplicationService } from '../../../../core/http/application.service';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';
import { Router } from '@angular/router';

@Component({
  selector: 'app-convention-details',
  templateUrl: './convention-details.component.html',
  styleUrls: ['./convention-details.component.css'],
})
export class ConventionDetailsComponent implements OnInit {

  @Input() page: string = 'client-show';
  @Input() client: Client;
  @Input() mission: Mission;
  @Input() convention: Convention;

  deleteModal: ConventionDeleteModal;

  billsForm: FormGroup = this.fb.group({});
  billsFormArray: FormArray = this.fb.array([]);

  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private modalService: SuiModalService,
    private missionService: MissionService,
    private applicationService: ApplicationService,
    private router: Router,
    private fb: FormBuilder,
  ) { }

  ngOnInit() {
    if (this.page === 'mission-show') {
      this.initBillsForm();
    }
  }

  initBillsForm() {
    for (const rate of this.mission.project.convention.rates) {
      this.billsFormArray.push(this.fb.group({
        amount: ['', Validators.required]
      }));
    }

    this.billsForm = this.fb.group({
      bills: this.billsFormArray
    });
  }

  get fa() { return this.billsForm.get('bills') as FormArray; }

  fag(index: number) { return this.fa.controls[index] as FormGroup; }

  openModal(convention: Convention) {
    this.deleteModal = new ConventionDeleteModal(
      convention.name,
      `Voulez-vous vraiment supprimer la convention ${convention.name} ?`,
      convention,
      this.client
    );

    this.modalService.open(this.deleteModal);
  }

  onSubmit() {
    this.submitted = true;
    this.loading = true;

    this.applicationService.getMissionApplications(this.mission, 'accepted').subscribe(applications => {
      const applicationsArray = [];

      for (const application of applications) {
        const billsArray = [];
        let i = 0;

        for (const rate of this.mission.project.convention.rates) {
          billsArray.push({
            id: application.bills[i] ? application.bills[i].id : null,
            rate_id: rate.id,
            amount: this.fag(i).controls['amount'].value,
          });
          i++;
        }

        applicationsArray.push({
          application_id: application.id,
          bills: billsArray,
        });
      }

      this.missionService.updateMissionBills({applications: applicationsArray}, this.mission).pipe(first())
        .subscribe(
          () => {
            this.router.navigate(['/'])
              .then(() => { this.router.navigate([`/missions/${this.mission.id}/heures`]); } );
            this.loading = false;
          },
          errors => {
            handleFormErrors(this.billsForm.controls.bills as FormGroup, errors);
            this.loading = false;
          }
        );
    });
  }

}
