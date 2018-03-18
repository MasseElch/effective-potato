import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { BudgetRoutingModule } from './budget-routing.module';
import { BudgetService } from './services/budget.service';
import { BudgetsComponent } from './components/budgets/budgets.component';
import { BudgetDetailsComponent } from './components/budget-details/budget-details.component';
import { UiModule } from '../ui/ui.module';
import { CategoriesComponent } from './components/categories/categories.component';
import { HundredthCurrencyModule } from '../hundredth-currency/hundredth-currency.module';
import { TextMaskModule } from 'angular2-text-mask';
import { FormsModule } from '../forms/forms.module';

@NgModule({
  imports: [
    CommonModule,

    TextMaskModule,

    FormsModule, UiModule, HundredthCurrencyModule,

    BudgetRoutingModule
  ],
  declarations: [
    BudgetsComponent,
    BudgetDetailsComponent,
    CategoriesComponent
  ],
  providers: [
    BudgetService
  ]
})
export class BudgetModule { }
