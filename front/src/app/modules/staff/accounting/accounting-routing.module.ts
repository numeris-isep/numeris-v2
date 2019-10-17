import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { AuthGuard } from '../../../core/guards/auth.guard';
import { AccountingIndexComponent } from './accounting-index/accounting-index.component';
import { AccountingShowComponent } from './accounting-show/accounting-show.component';

const accountingRoutes: Routes = [
  {
    path: 'comptabilite/:year/:month',
    canActivate: [AuthGuard],
    component: AccountingShowComponent,
  },
  {
    path: 'comptabilite/:year',
    canActivate: [AuthGuard],
    component: AccountingIndexComponent,
  },
  {
    path: 'comptabilite',
    canActivate: [AuthGuard],
    component: AccountingIndexComponent,
  },
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(accountingRoutes)
  ],
  exports: [RouterModule]
})
export class AccountingRoutingModule { }
