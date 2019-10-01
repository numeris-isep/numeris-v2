import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-verified-email',
  templateUrl: './verified-email.component.html'
})
export class VerifiedEmailComponent implements OnInit {

  @Input() emailVerifiedAt: string;

  constructor() { }

  ngOnInit() {
  }

}
