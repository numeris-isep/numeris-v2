import { Component, Input, OnInit } from '@angular/core';
import { Payslip } from '../../../../core/classes/models/payslip';

@Component({
  selector: 'app-profile-documents',
  templateUrl: './profile-documents.component.html',
  styleUrls: ['./profile-documents.component.css']
})
export class ProfileDocumentsComponent implements OnInit {

  @Input() payslips: Payslip[];

  constructor() { }

  ngOnInit() {
  }

}
