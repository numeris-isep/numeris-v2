import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AccountingComponent } from './accounting.component';
import { SuiModule } from 'ng2-semantic-ui';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { SharedModule } from '../../../shared/shared.module';
import { HttpClientModule } from '@angular/common/http';
import { AccountingRoutingModule } from './accounting-routing.module';
import { CalendarCardComponent } from './calendar-card/calendar-card.component';

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
    CalendarCardComponent,
  ],
})
export class AccountingModule { }
