import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { ScrollService } from '../../../core/services/scroll.service';
import { ContactUsModal } from '../modals/contact-us-modal/contact-us-modal.component';
import { ComponentModalConfig, SuiModalService } from 'ng2-semantic-ui';
import { AuthService } from '../../../core/http/auth/auth.service';
import { ActivatedRoute, Router } from '@angular/router';
import { ConfettiService, ConfettiType } from '../../../core/services/confetti.service';
import * as moment from 'moment';
import { PreviewModal } from '../modals/preview-modal/preview-modal.component';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  @ViewChild('template') template: ElementRef;

  @ViewChild('top') private top: ElementRef;
  @ViewChild('aboutUs') private aboutUs: ElementRef;
  @ViewChild('team') private team: ElementRef;
  @ViewChild('podium') private podium: ElementRef;
  @ViewChild('contactUs') private contactUs: ElementRef;

  @ViewChild('snowCanvas') private snowCanvas: ElementRef;

  isWinter: boolean = moment().isAfter(moment({d: 22, M: 11})) || moment().isBefore(moment({d: 20, M: 2}));

  private elements: {
    top: ElementRef,
    aboutUs: ElementRef,
    team: ElementRef,
    podium: ElementRef,
    contactUs: ElementRef
  };

  contactUsModal: ContactUsModal = new ContactUsModal();
  previewModal: PreviewModal = new PreviewModal(
    'assets/images/team/2019-2020/team.png',
    'Équipe 2018/2019'
  );

  constructor(
    private scrollService: ScrollService,
    private confettiService: ConfettiService,
    private modalService: SuiModalService,
    private router: Router,
    private route: ActivatedRoute,
    private authService: AuthService,
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
    this.rainSnow();
  }

  scrollToElement(anchor: string) {
    this.scrollService.scrollToElement(anchor);
  }

  openModal(modal: ComponentModalConfig<any, any, any>) {
    this.modalService.open(modal);
  }

  rainSnow() {
    if (this.isWinter) {
      this.confettiService.shoot(ConfettiType.Snow, this.snowCanvas.nativeElement);
    }
  }
}
