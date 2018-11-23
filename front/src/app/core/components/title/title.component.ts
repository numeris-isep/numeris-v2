import { Component, OnInit } from '@angular/core';
import { TitleService } from "../../services/title.service";

@Component({
  selector: 'app-title',
  templateUrl: './title.component.html'
})
export class TitleComponent implements OnInit {

  title: string;

  constructor(private titleService: TitleService) { }

  ngOnInit() {
    this.titleService.getHeaderTitle().subscribe((title) => this.title = title);
  }
}
