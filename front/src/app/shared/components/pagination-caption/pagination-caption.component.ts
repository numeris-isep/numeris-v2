import { Component, Input, OnInit } from '@angular/core';
import { IPagination } from "../../../core/classes/pagination/pagination-interface";

@Component({
  selector: 'app-pagination-caption',
  templateUrl: './pagination-caption.component.html',
  styleUrls: ['./pagination-caption.component.css']
})
export class PaginationCaptionComponent implements OnInit {

  @Input() paginatedObject: IPagination;

  constructor() { }

  ngOnInit() {
  }

}
