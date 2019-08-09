import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-password-form',
  templateUrl: './password-form.component.html',
  styleUrls: ['./password-form.component.css']
})
export class PasswordFormComponent implements OnInit {

  passwordForm: FormGroup;
  passwordStrength: number = 0;
  passwordMatch: boolean = false;
  strengthMessages: string[] = [];

  requirements = [
    { regex: /\d/, message: 'contenir au moins 1 chiffre' },
    { regex: /[a-z]/, message: 'contenir au moins 1 lettre minuscule' },
    { regex: /[A-Z]/, message: 'contenir au moins 1 lettre majuscule' },
    { regex: /[$&+,:;=?@#|'<>.^*()%!-]/, message: 'contenir au moins 1 caractère spécial' },
    { regex: /.{8,}/, message: 'être composé de 8 caractères minimum' },
  ];

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

  checkStrength() {
    const password = this.f.password.value.trim();
    const strengthMessages: string[] = [];
    this.passwordStrength = 0;

    for (const requirement of this.requirements) {
      if (requirement.regex.test(password)) {
        this.passwordStrength++;
      } else {
        strengthMessages.push(requirement.message);
      }
    }

    this.strengthMessages = strengthMessages;
    this.checkMatch();
  }

  checkMatch() {
    const password = this.f.password.value.trim();
    const passwordConf = this.f.password_confirmation.value.trim();

    if (password !== '' && passwordConf !== '') {
      this.passwordMatch = this.f.password.value === this.f.password_confirmation.value;
    }
  }

}
