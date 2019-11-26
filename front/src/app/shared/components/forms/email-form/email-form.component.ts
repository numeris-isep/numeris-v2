import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import * as ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Email } from '../../../../core/classes/email';

@Component({
  selector: 'app-email-form',
  templateUrl: './email-form.component.html',
  styleUrls: ['./email-form.component.css']
})
export class EmailFormComponent implements OnInit {

  emailForm: FormGroup;
  editor: ClassicEditor = ClassicEditor;

  @Input() email: Email;
  @Input() submitted: boolean;
  @Output() formReady: EventEmitter<FormGroup> = new EventEmitter<FormGroup>();

  constructor(private formBuilder: FormBuilder) { }

  ngOnInit() {
    this.initEmailForm();
    this.formReady.emit(this.emailForm);
  }

  initEmailForm() {
    this.emailForm = this.formBuilder.group({
      subject: [
        (this.email && this.email.subject) ? this.email.subject : '',
        Validators.required
      ],
      content: [
        (this.email && this.email.content) ? this.email.content : '',
        Validators.required
      ],
      // attachments: [''],
    });
  }

  get f() { return this.emailForm.controls; }

}
