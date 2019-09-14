import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { AccountingComponent } from './accounting.component';
import { AuthGuard } from '../../../core/guards/auth.guard';

const accountingRoutes: Routes = [
  {
    path: 'comptabilite',
    component: AccountingComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Comptabilité',
    }
  }
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(accountingRoutes)
  ],
  exports: [RouterModule]
})
export class AccountingRoutingModule { }
