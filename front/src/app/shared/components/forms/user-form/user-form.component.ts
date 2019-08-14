import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { AbstractControl, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { User } from '../../../../core/classes/models/user';
import * as moment from 'moment';

@Component({
  selector: 'app-user-form',
  templateUrl: './user-form.component.html'
})
export class UserFormComponent implements OnInit {

  userForm: FormGroup;
  promotions: { promotion: number, id: number }[] = [];

  @Input() user: User;
  @Input() submitted: boolean;
  @Output() formReady: EventEmitter<FormGroup> = new EventEmitter<FormGroup>();

  constructor(private formBuilder: FormBuilder) { }

  ngOnInit() {
    this.initPromotions();
    this.initSubscribeForm();
    this.formReady.emit(this.userForm);
  }

  get f() { return this.userForm.controls; }

  initPromotions() {
    let currentYear = moment().get('year');

    for (let i = 0; i < 7; i++) {
      this.promotions.push({ promotion: currentYear, id: currentYear});
      currentYear++;
    }
  }

  initSubscribeForm() {
    this.userForm = this.formBuilder.group({
      email: [this.user ? this.user.email : '', Validators.required],
      first_name: [this.user ? this.user.firstName : '', Validators.required],
      last_name: [this.user ? this.user.lastName : '', Validators.required],
      promotion: [this.user ? parseInt(this.user.promotion) : '', Validators.required],
      birth_date: [this.user ? new Date(this.user.birthDate) : '', Validators.required],
    });
  }

  suffix() {
    const email: AbstractControl = this.f.email;

    if (! email.value.includes('@isep.fr')) {
      email.setValue(email.value + 'isep.fr');
    }
  }

}
