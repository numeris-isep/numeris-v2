import { AfterViewInit, Component, Input, OnInit } from '@angular/core';
import { Project } from '../../../../core/classes/models/project';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ProjectService } from '../../../../core/http/project.service';
import { Router } from '@angular/router';
import { Client } from '../../../../core/classes/models/client';
import { ClientService } from '../../../../core/http/client.service';
import { ConventionService } from '../../../../core/http/convention.service';
import { Convention } from '../../../../core/classes/models/convention';
import { Observable } from 'rxjs';
import { dateToString } from '../../../../shared/utils';
import { first } from 'rxjs/operators';
import { handleFormErrors } from '../../../../core/functions/form-error-handler';
import { AlertService } from '../../../../core/services/alert.service';

@Component({
  selector: 'app-project-form',
  templateUrl: './project-form.component.html'
})
export class ProjectFormComponent implements OnInit, AfterViewInit {

  @Input() project: Project;
  @Input() client: Client;
  clients: Client[];
  conventions: Convention[];

  projectForm: FormGroup;
  initialValue: object;
  loading: boolean = false;
  submitted: boolean = false;

  constructor(
    private fb: FormBuilder,
    private projectService: ProjectService,
    private clientService: ClientService,
    private conventionService: ConventionService,
    private alertService: AlertService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.getClients();
    this.getConventions(this.client || (this.project ? this.project.client : null));
    this.initForm();
  }

  ngAfterViewInit() {
    this.initialValue = this.projectForm.value;
  }

  initForm() {
    this.projectForm = this.fb.group({
      name: [
        this.project ? this.project.name : '',
        Validators.required,
      ],
      client_id: [
        this.project ? this.project.client.id : (this.client ? this.client.id : ''),
        Validators.required,
      ],
      convention_id: [
        this.project ? this.project.convention.id : '',
        Validators.required,
      ],
      start_at: [
        this.project ? new Date(this.project.startAt) : '',
        Validators.required,
      ],
      is_private: [this.project ? this.project.isPrivate : false],
    });
  }

  get f() { return this.projectForm.controls; }

  onSubmit() {
    this.submitted = true;

    if (this.projectForm.invalid) { return; }

    this.loading = true;
    this.f.start_at.setValue(dateToString(this.f.start_at.value)); // Handle date
    this.f.is_private.setValue(!!this.f.is_private.value);

    let projectRequest: Observable<Project>;

    if (!this.project) {
      projectRequest = this.projectService.addProject(this.projectForm.value as Project);
    } else {
      projectRequest = this.projectService.updateProject(this.projectForm.value as Project, this.project);
    }

    projectRequest.pipe(first())
      .subscribe(
        project => {
          this.loading = false;
          this.router.navigate([`/projets/${project.id}`]);
          if (this.project) { this.alertService.success([`Le projet ${project.name} a bien été modifié.`]); }
        },
        errors => {
          handleFormErrors(this.projectForm, errors);
          this.loading = false;
        }
      );
  }

  getClients() {
    this.clientService.getClients().subscribe(clients => this.clients = clients);
  }

  getConventions(client: Client | number) {
    if (client) {
      this.conventionService.getClientConventions(client).subscribe(conventions => this.conventions = conventions);
    }
  }

}
