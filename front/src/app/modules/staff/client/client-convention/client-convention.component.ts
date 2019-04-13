import { Component, Input, OnInit } from '@angular/core';
import { Convention } from "../../../../core/classes/models/convention";

@Component({
  selector: 'app-client-convention',
  templateUrl: './client-convention.component.html'
})
export class ClientConventionComponent implements OnInit {

  @Input() conventions: Convention[];

  constructor() { }

  ngOnInit() {
  }

}
