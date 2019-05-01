import { Component, Input, OnInit } from '@angular/core';
import { Project } from "../../../../core/classes/models/project";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ProjectService } from "../../../../core/http/project.service";
import { Router } from "@angular/router";
import { Client } from "../../../../core/classes/models/client";
import { ClientService } from "../../../../core/http/client.service";
import { ConventionService } from "../../../../core/http/convention.service";
import { Convention } from "../../../../core/classes/models/convention";
import * as moment from "moment";
import { Observable } from "rxjs";
import { dateToISO, dateToString } from "../../../../shared/utils";
import { first } from "rxjs/operators";
import { handleFormErrors } from "../../../../core/functions/form-error-handler";

@Component({
  selector: 'app-project-form',
  templateUrl: './project-form.component.html'
})
export class ProjectFormComponent implements OnInit {

  @Input() project: Project;
  @Input() client: Client;
  clients: Client[];
  conventions: Convention[];

  projectForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;
  currentDate: Date = moment().subtract(1, 'month').toDate();

  constructor(
    private fb: FormBuilder,
    private projectService: ProjectService,
    private clientService: ClientService,
    private conventionService: ConventionService,
    private router: Router
  ) { }

  ngOnInit() {
    this.getClients();

    this.projectForm = this.fb.group({
      name: [
        this.project ? this.project.name : '',
        Validators.required,
      ],
      client_id: [
        this.project ? this.project.clientId : (this.client ? this.client.id : ''),
        Validators.required,
      ],
      convention_id: [
        this.project ? this.project.conventionId : '',
        Validators.required,
      ],
      start_at: [
        this.project ? this.project.startAt : '',
        Validators.required,
      ],
      is_private: [this.project ? this.project.isPrivate : false],
    });
  }

  get f() { return this.projectForm.controls }

  onSubmit() {
    this.submitted = true;

    if (this.projectForm.invalid) return;

    this.loading = true;
    this.f.start_at.setValue(dateToString(this.f.start_at.value)); // Handle date
    this.f.is_private.setValue(!!this.f.is_private.value);

    console.log(this.projectForm.value);

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
        },
        errors => {
          handleFormErrors(this.projectForm, errors);
          this.loading = false;
        }
      )
  }

  getClients() {
    this.clientService.getClients().subscribe(clients => this.clients = clients);
  }

  getConventions(client: Client | number) {
    if (client !== undefined) {
      this.conventionService.getClientConventions(client).subscribe(conventions => this.conventions = conventions);
    }
  }

}
