import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-password-form',
  templateUrl: './password-form.component.html',
  styleUrls: ['./password-form.component.css']
})
export class PasswordFormComponent implements OnInit {

  passwordForm: FormGroup;

  @Input() submitted: boolean;
  @Output() formReady: EventEmitter<FormGroup> = new EventEmitter<FormGroup>();

  constructor(private formBuilder: FormBuilder) { }

  ngOnInit() {
    this.initPasswordForm();
    this.formReady.emit(this.passwordForm);
  }

  get f() { return this.passwordForm.controls; }

  initPasswordForm() {
    this.passwordForm = this.formBuilder.group({
      password: ['', Validators.required],
      password_confirmation: ['', Validators.required],
    });
  }

}
