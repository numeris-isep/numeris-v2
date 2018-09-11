import { Component, OnInit } from '@angular/core';
import { SuiModal, ComponentModalConfig, ModalSize } from "ng2-semantic-ui"
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { ActivatedRoute, Router } from "@angular/router";
import { AuthService } from "../../../auth/auth.service";
import { TokenService } from "../../../auth/token.service";
import { AlertService } from "../../alert/alert.service";
import { SuiModalService } from "ng2-semantic-ui";
import { first } from "rxjs/operators";

@Component({
  selector: 'login-modal',
  templateUrl: './login-modal.component.html'
})
export class LoginModalComponent implements OnInit {

  loginForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;
  returnUrl: string;

  constructor(
    public modal: SuiModal<void, void, void>,
    private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private authService: AuthService,
    private tokenService: TokenService,
    private alertService: AlertService,
    private modalService: SuiModalService
  ) { }

  ngOnInit() {
    this.loginForm = this.formBuilder.group({
      email: ['', Validators.required],
      password: ['', Validators.required]
    });

    // reset login status
    this.authService.resetAuthStatus();

    // get return url from route parameters or default to '/profile'
    this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/dashboard';
  }

  // convenient getter for easy access to form fields
  get f() { return this.loginForm.controls; }

  onSubmit() {
    this.submitted = true;

    // stop here if form is invalid
    if (this.loginForm.invalid) {
      return;
    }

    this.loading = true;
    this.authService.login(this.f.email.value, this.f.password.value)
      .pipe(first())
      .subscribe(
        data => {
          this.router.navigate([this.returnUrl]);
        },
        error => {
          this.alertService.error(error);
          this.loading = false;
        });
  }
}

export class LoginModal extends ComponentModalConfig<void, void, void> {

  constructor(
    size = ModalSize.Small,
    isClosable: boolean = true,
    transitionDuration: number = 200
  ) {
    super(LoginModalComponent);

    this.isClosable = isClosable;
    this.transitionDuration = transitionDuration;
    this.size = size;
  }
}
