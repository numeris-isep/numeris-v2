import { AfterViewInit, Component, Input, OnInit } from '@angular/core';
import { Mission } from '../../../../core/classes/models/mission';
import { Project } from '../../../../core/classes/models/project';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MissionService } from '../../../../core/http/mission.service';
import { AlertService } from '../../../../core/services/alert.service';
import { Router } from '@angular/router';
import { ProjectService } from '../../../../core/http/project.service';
import { dateToISO, dateToString } from '../../../../shared/utils';
import { forkJoin, Observable } from 'rxjs';
import { first } from 'rxjs/operators';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';
import { UserService } from '../../../../core/http/user.service';
import { User } from '../../../../core/classes/models/user';
import { Contact } from '../../../../core/classes/models/contact';
import { ContactService } from '../../../../core/http/contact.service';

@Component({
  selector: 'app-mission-form',
  templateUrl: './mission-form.component.html'
})
export class MissionFormComponent implements OnInit, AfterViewInit {

  @Input() mission: Mission;
  @Input() project: Project;

  projects: Project[];
  users: User[];
  contacts: Contact[];

  missionForm: FormGroup;
  initialValue: object;
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private fb: FormBuilder,
    private missionService: MissionService,
    private userService: UserService,
    private contactService: ContactService,
    private projectService: ProjectService,
    private alertService: AlertService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.getData();
    this.initForm();
  }

  ngAfterViewInit() {
    this.initialValue = this.missionForm.value;
  }

  initForm() {
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
        this.mission ? this.mission.project.id : (this.project ? this.project.id : ''),
        Validators.required,
      ],
      user_id: [
        this.mission ? this.mission.user.id : '',
        Validators.required,
      ],
      contact_id: [
        this.mission ? (this.mission.contact ? this.mission.contact.id : '') : '',
      ],
      start_at: [
        this.mission ? new Date(dateToISO(this.mission.startAt)) : '',
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
    });
  }

  get f() { return this.missionForm.controls; }

  addAddressForm(addressForm: FormGroup) {
    this.missionForm.addControl('address', addressForm);
  }

  onSubmit() {
    this.submitted = true;

    if (this.missionForm.invalid) { return; }

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
          if (this.mission) { this.alertService.success([`La mission ${mission.title} a bien été modifiée.`]); }
        },
        errors => {
          handleFormErrors(this.missionForm, errors);
          this.loading = false;
        }
      );
  }

  getData() {
    forkJoin([this.getProjects(), this.getUsers(), this.getContacts()]).subscribe(data => {
      this.projects = data[0];
      this.users = data[1].data;
      this.contacts = data[2];
    });
  }

  getProjects() {
    return this.projectService.getProjects();
  }

  getUsers() {
    return this.userService.getPaginatedUsers(null, null, null, null, null, null, true);
  }

  getContacts() {
    return this.contactService.getContacts();
  }

  fullName(option: Contact | User, query?: string): string {
    return `${option.firstName} ${option.lastName.toUpperCase()}`;
  }

}
