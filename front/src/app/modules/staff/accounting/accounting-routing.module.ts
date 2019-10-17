import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { AuthGuard } from '../../../core/guards/auth.guard';
import { AccountingIndexComponent } from './accounting-index/accounting-index.component';
import * as moment from 'moment';
import { AccountingShowComponent } from './accounting-show/accounting-show.component';

const year = moment().format('Y');

const accountingRoutes: Routes = [
  // {
  //   path: 'comptabilite',
  //   canActivate: [AuthGuard],
  //   children: [
  //     {
  //       path: ':year',
  //       children: [
  //         {
  //           path: ':month',
  //           component: AccountingShowComponent,
  //         },
  //         {
  //           path: '',
  //           component: AccountingIndexComponent,
  //         },
  //       ],
  //     },
  //   ]
  // },
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
  // {
  //   path: 'comptabilite',
  //   redirectTo: 'comptabilite/' + year,
  //   pathMatch: 'full',
  //   canActivate: [AuthGuard],
  // },
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(accountingRoutes)
  ],
  exports: [RouterModule]
})
export class AccountingRoutingModule { }
