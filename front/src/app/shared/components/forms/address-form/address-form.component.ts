import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Address } from '../../../../core/classes/models/address';

@Component({
  selector: 'app-address-form',
  templateUrl: './address-form.component.html'
})
export class AddressFormComponent implements OnInit {

  addressForm: FormGroup;

  @Input() address: Address;
  @Input() submitted: boolean;
  @Output() formReady: EventEmitter<FormGroup> = new EventEmitter<FormGroup>();

  constructor(private formBuilder: FormBuilder) {
  }

  ngOnInit() {
    this.initAddressForm();
  }

  initAddressForm() {
    this.addressForm = this.formBuilder.group({
      street: [this.address ? this.address.street : '', Validators.required],
      zip_code: [this.address ? this.address.zipCode : '', Validators.required],
      city: [this.address ? this.address.city : '', Validators.required],
    });

    this.formReady.emit(this.addressForm);
  }

  get f() {
    return this.addressForm.controls;
  }

}


