import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-terms-of-use',
  templateUrl: './terms-of-use.component.html',
  styleUrls: ['./terms-of-use.component.css']
})
export class TermsOfUseComponent implements OnInit {

  public allChecked: boolean = false;

  public checkboxes = [
    { isChecked: false }, // checkbox 1
    { isChecked: false }, // checkbox 2
    { isChecked: false }, // checkbox 3
    { isChecked: false }, // checkbox 4
    { isChecked: false }, // checkbox 5
    { isChecked: false }, // checkbox 6
    { isChecked: false }, // checkbox 7
    { isChecked: false }, // checkbox 8
    { isChecked: false }, // checkbox 9
    { isChecked: false }, // checkbox 10
  ];

  constructor() { }

  ngOnInit() {
    this.check();
  }

  check() {
    this.allChecked = this.checkboxes.every(checkbox => checkbox.isChecked === true);
  }

  mainCheckbox(isChecked) {
    for (let i = 0; i < this.checkboxes.length; i++) {
      this.checkboxes[i].isChecked = isChecked;
    }
    this.check();
  }
}
