import { Component, ElementRef, Injectable, OnInit, ViewChild } from '@angular/core';
import { ScrollToElementService } from "../../shared/_services/scroll-to-element.service";
import { ContactUsModal } from "../../shared/modals/contact-us-modal/contact-us-modal.component";
import { SuiModalService } from 'ng2-semantic-ui';
import { AuthService } from "../../auth/auth.service";
import { Router } from "@angular/router";

@Injectable()
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  @ViewChild('top') private top: ElementRef;
  @ViewChild('aboutUs') private aboutUs: ElementRef;
  @ViewChild('team') private team: ElementRef;
  @ViewChild('podium') private podium: ElementRef;
  @ViewChild('contactUs') private contactUs: ElementRef;

  private elements: ElementRef[];

  private modal: ContactUsModal = new ContactUsModal();

  constructor(
    private scrollService: ScrollToElementService,
    private modalService: SuiModalService,
    private router: Router,
    private authService: AuthService
  ) { }

  ngOnInit() {
    this.authService.isLoggedIn.subscribe(
      isLoggedIn => {
        if (isLoggedIn) {
          this.router.navigate(['/dashboard']);
        }
      }
    );

    this.elements = [
      this.top, this.aboutUs, this.team, this.podium, this.contactUs
    ];

    this.scrollService.setPageElements(this.elements);
  }

  scrollToElement(id: number) {
    this.scrollService.scrollToElement(id);
  }

  openModal() {
    this.modalService.open(this.modal);
  }
}
