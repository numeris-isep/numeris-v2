import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { AbstractControl, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { User } from '../../../../core/classes/models/user';
import * as moment from 'moment';
import { Moment } from 'moment';
import { dateToISO } from '../../../utils';

@Component({
  selector: 'app-user-form',
  templateUrl: './user-form.component.html'
})
export class UserFormComponent implements OnInit {

  userForm: FormGroup;
  promotions: { promotion: number, id: number }[] = [];

  maxDate: Moment = moment().startOf('month').subtract(18, 'year');

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
    const currentYear = moment().get('year');

    for (let i = 0; i < 7; i++) {
      this.promotions.push({ promotion: currentYear + i, id: currentYear + i});
    }
  }

  initSubscribeForm() {
    this.userForm = this.formBuilder.group({
      email: [this.user ? this.user.email : '', Validators.required],
      first_name: [this.user ? this.user.firstName : '', Validators.required],
      last_name: [this.user ? this.user.lastName : '', Validators.required],
      promotion: [this.user ? parseInt(this.user.promotion) : '', Validators.required],
      birth_date: [this.user ? new Date(dateToISO(this.user.birthDate)) : '', Validators.required],
    });
  }

  suffix() {
    const email: AbstractControl = this.f.email;

    if (! email.value.includes('@isep.fr')) {
      email.setValue(email.value + 'isep.fr');
    }
  }

}
