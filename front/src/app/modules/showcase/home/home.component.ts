import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { ScrollService } from "../../../core/services/scroll.service";
import { ContactUsModal } from "../modals/contact-us-modal/contact-us-modal.component";
import { SuiModalService } from 'ng2-semantic-ui';
import { AuthService } from "../../../core/http/auth/auth.service";
import { ActivatedRoute, Router } from "@angular/router";

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

  private elements: {
    top: ElementRef,
    aboutUs: ElementRef,
    team: ElementRef,
    podium: ElementRef,
    contactUs: ElementRef
  };

  private modal: ContactUsModal = new ContactUsModal();

  private anchor: string;

  constructor(
    private scrollService: ScrollService,
    private modalService: SuiModalService,
    private router: Router,
    private route: ActivatedRoute,
    private authService: AuthService
  ) { }

  ngOnInit() {
    this.authService.isLoggedIn.subscribe(
      isLoggedIn => {
        if (isLoggedIn) {
          this.router.navigate(['/tableau-de-bord']);
        }
      }
    );

    this.elements = {
      top: this.top,
      aboutUs: this.aboutUs,
      team: this.team,
      podium: this.podium,
      contactUs: this.contactUs
    };

    this.scrollService.setPageElements(this.elements);
  }

  scrollToElement(anchor: string) {
    this.scrollService.scrollToElement(anchor);
  }

  openModal() {
    this.modalService.open(this.modal);
  }
}
