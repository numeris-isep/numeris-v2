import { Component, OnInit } from '@angular/core';
import { SuiLocalizationService } from 'ng2-semantic-ui';
import fr from 'ng2-semantic-ui/locales/fr';
import { AuthService } from './http/auth/auth.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html'
})
export class AppComponent implements OnInit {

  constructor(
    public localizationService: SuiLocalizationService,
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
  }

}
