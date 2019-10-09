import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AccountingComponent } from './accounting.component';
import { SuiModule } from 'ng2-semantic-ui';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { SharedModule } from '../../../shared/shared.module';
import { HttpClientModule } from '@angular/common/http';
import { AccountingRoutingModule } from './accounting-routing.module';
import { AccountingDetailsComponent } from './accounting-details/accounting-details.component';
import { AccountingIndexComponent } from './accounting-index/accounting-index.component';
import { AccountingListComponent } from './accounting-list/accounting-list.component';

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
    AccountingDetailsComponent,
    AccountingIndexComponent,
    AccountingListComponent,
  ],
})
export class AccountingModule { }
