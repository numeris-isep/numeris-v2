import { Component } from '@angular/core';
import { SuiLocalizationService } from 'ng2-semantic-ui';
import fr from 'ng2-semantic-ui/locales/fr';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html'
})
export class AppComponent {

  constructor(public localizationService: SuiLocalizationService) {

    // Set Semantic-UI component local to "french"
    localizationService.load('fr', fr);
    localizationService.patch('fr', {
      search: { placeholder: 'Custom!'}
    });
    localizationService.setLanguage('fr');
  }

}
