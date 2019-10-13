import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AccountingComponent } from './accounting.component';
import { SuiModule } from 'ng2-semantic-ui';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { SharedModule } from '../../../shared/shared.module';
import { HttpClientModule } from '@angular/common/http';
import { AccountingRoutingModule } from './accounting-routing.module';
import { AccountingSummaryComponent } from './accounting-summary/accounting-summary.component';
import { AccountingIndexComponent } from './accounting-index/accounting-index.component';
import { AccountingListComponent } from './accounting-list/accounting-list.component';
import { AccountingShowComponent } from './accounting-show/accounting-show.component';
import { AccountingActionsComponent } from './accounting-actions/accounting-actions.component';
import { AccountingDetailsComponent } from './accounting-details/accounting-details.component';
import { AccountingTabsetComponent } from './accounting-tabset/accounting-tabset.component';

@NgModule({
  imports: [
    CommonModule,
    SuiModule,
    FormsModule,
    ReactiveFormsModule,
    SharedModule,
    HttpClientModule,
    AccountingRoutingModule,
  ],
  declarations: [
    AccountingComponent,
    AccountingSummaryComponent,
    AccountingIndexComponent,
    AccountingListComponent,
    AccountingShowComponent,
    AccountingActionsComponent,
    AccountingDetailsComponent,
    AccountingTabsetComponent,
  ],
})
export class AccountingModule { }
