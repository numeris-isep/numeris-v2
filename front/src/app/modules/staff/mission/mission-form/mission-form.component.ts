import { Component, Input, OnInit } from '@angular/core';
import { Mission } from "../../../../core/classes/models/mission";
import { Project } from "../../../../core/classes/models/project";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { MissionService } from "../../../../core/http/mission.service";
import { AlertService } from "../../../../core/services/alert.service";
import { Router } from '@angular/router';
import { ProjectService } from "../../../../core/http/project.service";
import { dateToString } from "../../../../shared/utils";
import { Observable } from "rxjs";
import { first } from "rxjs/operators";
import { handleFormErrors } from "../../../../core/functions/form-error-handler";

@Component({
  selector: 'app-mission-form',
  templateUrl: './mission-form.component.html'
})
export class MissionFormComponent implements OnInit {

  @Input() mission: Mission;
  @Input() project: Project;
  projects: Project[];

  missionForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private fb: FormBuilder,
    private missionService: MissionService,
    private projectService: ProjectService,
    private alertService: AlertService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.getProjects();

    this.missionForm = this.fb.group({
      title: [
        this.mission ? this.mission.title : '',
        Validators.required,
      ],
      description: [
        this.mission ? this.mission.description : '',
        Validators.required,
      ],
      project_id: [
        this.mission ? this.mission.project.id : '',
        Validators.required,
      ],
      start_at: [
        this.mission ? new Date(this.mission.startAt) : '',
        Validators.required,
      ],
      duration: [
        this.mission ? this.mission.duration : '',
        Validators.required,
      ],
      capacity: [
        this.mission ? this.mission.capacity : '',
        Validators.required,
      ],
      address: this.fb.group({
        street: [
          this.mission ? this.mission.address.street : '',
          Validators.required,
        ],
        zip_code: [
          this.mission ? this.mission.address.zipCode : '',
          Validators.required,
        ],
        city: [
          this.mission ? this.mission.address.city : '',
          Validators.required,
        ],
      })
    });
  }

  get f() { return this.missionForm.controls }

  fa(field: string) { return this.missionForm.get(`address.${field}`); }

  onSubmit() {
    this.submitted = true;

    if (this.missionForm.invalid) return;

    this.loading = true;
    this.f.start_at.setValue(dateToString(this.f.start_at.value)); // Handle date

    let missionRequest: Observable<Mission>;

    if (!this.mission) {
      missionRequest = this.missionService.addMission(this.missionForm.value as Mission);
    } else {
      missionRequest = this.missionService.updateMission(this.missionForm.value as Mission, this.mission);
    }

    missionRequest.pipe(first())
      .subscribe(
        mission => {
          this.loading = false;
          this.router.navigate([`/missions/${mission.id}`]);
          if (this.mission) this.alertService.success([`La mission ${mission.title} a bien été modifiée.`]);
        },
        errors => {
          handleFormErrors(this.missionForm, errors);
          this.loading = false;
        }
      );
  }

  getProjects() {
    this.projectService.getProjects().subscribe(projects => this.projects = projects);
  }

}
