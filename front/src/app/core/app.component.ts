import { Component, OnInit } from '@angular/core';
import { SuiLocalizationService } from 'ng2-semantic-ui';
import fr from 'ng2-semantic-ui/locales/fr';
import { AuthService } from './http/auth/auth.service';
import { SwUpdate } from '@angular/service-worker';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html'
})
export class AppComponent implements OnInit {

  constructor(
    public localizationService: SuiLocalizationService,
    private swUpdate: SwUpdate,
    private authService: AuthService,
  ) {

    // Set Semantic-UI component local to "french"
    localizationService.load('fr', fr);
    localizationService.patch('fr', {
      search: { placeholder: 'Custom!'}
    });
    localizationService.setLanguage('fr');
  }

  ngOnInit() {
    this.authService.checkAuth();
    this.notifyNewVersion();
  }

  notifyNewVersion() {
    if (this.swUpdate.isEnabled) {
      this.swUpdate.available.subscribe(() => {
        if (confirm('Une nouvelle version est disponible, recharger la page ?')) {
          window.location.reload();
        }
      });
    }
  }

}
