import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { User } from '../../../../core/classes/models/user';
import { countries } from '../../../pipes/country-code.pipe';

@Component({
  selector: 'app-profile-form',
  templateUrl: './profile-form.component.html'
})
export class ProfileFormComponent implements OnInit {

  profileForm: FormGroup;
  nationalities = countries();

  @Input() user: User;
  @Input() submitted: boolean;
  @Output() formReady: EventEmitter<FormGroup> = new EventEmitter<FormGroup>();

  constructor(private formBuilder: FormBuilder) { }

  ngOnInit() {
    this.initProfileForm();
    this.formReady.emit(this.profileForm);
  }

  initProfileForm() {
    this.profileForm = this.formBuilder.group({
      birth_city: [this.user ? this.user.birthCity : '', Validators.required],
      phone: [this.user ? this.user.phone : '', Validators.required],
      nationality: [this.user ? this.user.nationality : '', Validators.required],
      social_insurance_number: [this.user ? this.user.socialInsuranceNumber : '', Validators.required],
      iban: [this.user ? this.user.iban : '', Validators.required],
      bic: [this.user ? this.user.bic : '', Validators.required],
    });
  }

  get f() { return this.profileForm.controls; }

  addUserForm(userForm: FormGroup) {
    this.profileForm.addControl('first_name', userForm.controls.first_name);
    this.profileForm.addControl('last_name', userForm.controls.last_name);
    this.profileForm.addControl('email', userForm.controls.email);
    this.profileForm.addControl('promotion', userForm.controls.promotion);
    this.profileForm.addControl('birth_date', userForm.controls.birth_date);
  }

  addPasswordForm(passwordForm: FormGroup) {
    this.profileForm.addControl('password', passwordForm.controls.password);
    this.profileForm.addControl('password_confirmation', passwordForm.controls.password_confirmation);
  }

  addAddressForm(addressForm: FormGroup) {
    this.profileForm.addControl('address', addressForm);
  }

}
