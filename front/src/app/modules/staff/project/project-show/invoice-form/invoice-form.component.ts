import { Component, ElementRef, Input, OnInit, ViewChild } from '@angular/core';
import { Project } from '../../../../../core/classes/models/project';
import { ProjectService } from '../../../../../core/http/project.service';
import { AlertService } from '../../../../../core/services/alert.service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { handleFormErrors } from '../../../../../core/functions/form-error-handler';

@Component({
  selector: 'app-invoice-form',
  templateUrl: './invoice-form.component.html'
})
export class InvoiceFormComponent implements OnInit {

  @Input() project: Project;
  @ViewChild('popup') popup: ElementRef;

  invoiceForm: FormGroup;
  submitted: boolean = false;
  loading: boolean = false;

  constructor(
    private projectService: ProjectService,
    private formBuilder: FormBuilder,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.initForm();
  }

  initForm() {
    this.invoiceForm = this.formBuilder.group({
      time_limit: ['', Validators.required]
    });
  }

  get f() { return this.invoiceForm.controls; }

  calculate() {
    this.submitted = true;

    if (this.project.step === 'hiring') { return; }

    this.loading = true;

    this.projectService.updateProjectInvoice(this.project.id, this.invoiceForm.value.time_limit)
      .subscribe(invoice => {
          this.loading = false;
          Object.assign(this.project, { invoice: invoice });
          this.alertService.success([`La facture de ce projet a bien été générée.`]);
          // @ts-ignore
          this.popup.close();
        },
        error => {
          handleFormErrors(this.invoiceForm, error);
          this.loading = false;
        }
      );
  }

}
