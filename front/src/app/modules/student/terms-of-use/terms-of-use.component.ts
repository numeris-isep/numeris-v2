import { Component, OnInit } from '@angular/core';
import { UserService } from "../../../core/http/user.service";
import { User } from "../../../core/classes/models/user";
import { AuthService } from "../../../core/http/auth/auth.service";
import { AlertService } from "../../../core/services/alert.service";
import { Router } from "@angular/router";

@Component({
  selector: 'app-terms-of-use',
  templateUrl: './terms-of-use.component.html',
  styleUrls: ['./terms-of-use.component.css']
})
export class TermsOfUseComponent implements OnInit {

  user: User;
  loading: boolean =  false;
  accepted: boolean = false;
  allDisabled: boolean = false;
  allChecked: boolean = false;

  checkboxes = [
    { isChecked: false, isDisabled: false }, // checkbox 1
    { isChecked: false, isDisabled: false }, // checkbox 2
    { isChecked: false, isDisabled: false }, // checkbox 3
    { isChecked: false, isDisabled: false }, // checkbox 4
    { isChecked: false, isDisabled: false }, // checkbox 5
    { isChecked: false, isDisabled: false }, // checkbox 6
    { isChecked: false, isDisabled: false }, // checkbox 7
    { isChecked: false, isDisabled: false }, // checkbox 8
    { isChecked: false, isDisabled: false }, // checkbox 9
    { isChecked: false, isDisabled: false }, // checkbox 10
  ];

  constructor(
    private userService: UserService,
    private authService: AuthService,
    private alertService: AlertService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.getCurrentUser();
    this.check();
  }

  getCurrentUser() {
    this.authService.getCurrentUser().subscribe(user => {
      this.user = user;
      this.accepted = this.user.touAccepted;
      this.allCheckboxes(this.accepted, this.accepted);
    });
  }

  check() {
    this.allChecked = this.checkboxes.every(checkbox => checkbox.isChecked === true);
  }

  mainCheckbox(isChecked) {
    this.allCheckboxes(isChecked);
    this.check();
  }

  allCheckboxes(areChecked: boolean, areDisabled?: boolean) {
    this.allChecked = areChecked;
    this.allDisabled = areDisabled;
    for (let i = 0; i < this.checkboxes.length; i++) {
      this.checkboxes[i].isChecked = areChecked;
      this.checkboxes[i].isDisabled = areDisabled;
    }
  }

  updateTermsOfUse() {
    this.loading = true;

    this.userService.updateUserTermsOfUse(this.user).subscribe(
      _ => {
        this.router.navigate(['/'])
          .then(() => { this.router.navigate(['/conditions-dutilisation']); } );
      },
      error => {
        this.loading = false;
      }
    );
  }
}
