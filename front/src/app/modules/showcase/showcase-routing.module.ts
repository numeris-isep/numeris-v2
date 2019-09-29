import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ResetPasswordComponent } from './reset-password/reset-password.component';

const showcaseRoutes: Routes = [
  {
    path: 'mot-de-passe/reinitialiser',
    component: ResetPasswordComponent,
    data: {
      title: 'Réinitialiser le mot de passe'
    }
  }
];

@NgModule({
  imports: [
    RouterModule.forChild(showcaseRoutes)
  ],
  exports: [RouterModule]
})
export class ShowcaseRoutingModule { }
