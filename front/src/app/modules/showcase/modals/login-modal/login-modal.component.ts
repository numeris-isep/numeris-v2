import { Component, OnInit } from '@angular/core';
import { SuiModal, ComponentModalConfig, ModalSize } from "ng2-semantic-ui"
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ActivatedRoute, Router } from "@angular/router";
import { AuthService } from "../../../../core/http/auth/auth.service";
import { first } from "rxjs/operators";
import { AlertService } from "../../../../core/services/alert.service";
import { handleFormErrors } from "../../../../core/functions/form-error-handler";

export interface ILoginModalContext {
  question: string;
  returnUrl: string;
}

@Component({
  selector: 'login-modal',
  templateUrl: './login-modal.component.html'
})
export class LoginModalComponent implements OnInit {

  loginForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;
  question: string = this.loginModal.context.question;
  returnUrl: string = this.loginModal.context.returnUrl;

  constructor(
    public loginModal: SuiModal<ILoginModalContext, void, void>,
    private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private authService: AuthService,
    private alertService: AlertService
  ) { }

  ngOnInit() {
    this.loginForm = this.formBuilder.group({
      email: ['', Validators.required],
      password: ['', Validators.required]
    });

    // reset auth status
    this.authService.logout();

    // get return url from route parameters or default to home
    if (!this.returnUrl) this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';
  }

  // convenient getter for easy access to form fields
  get f() { return this.loginForm.controls; }

  onSubmit() {
    this.submitted = true;

    // stop here if form is invalid
    if (this.loginForm.invalid) return;

    this.loading = true;
    this.authService.login(this.f.email.value, this.f.password.value)
      .pipe(first())
      .subscribe(
        _ => {
          this.alertService.success(['Vous êtes connecté !'], null, true);
          this.router.navigate(['/profil'])
            .then(() => { this.router.navigate([this.returnUrl]) } );
          this.loginModal.approve(undefined); // <-- make the modal disappear
        },
        errors => {
          handleFormErrors(this.loginForm, errors);
          this.loading = false;
        });
  }
}

export class LoginModal extends ComponentModalConfig<ILoginModalContext, void, void> {

  constructor(
    question = null,
    returnUrl = '/',
    size = ModalSize.Small,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(LoginModalComponent, { question, returnUrl });

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }
}
