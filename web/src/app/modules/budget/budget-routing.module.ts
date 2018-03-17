import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { BudgetsComponent } from './components/budgets/budgets.component';
import { BudgetDetailsComponent } from './components/budget-details/budget-details.component';
import { CategoriesComponent } from './components/categories/categories.component';

const routes: Routes = [
  {path: '', component: BudgetsComponent},
  {
    path: ':id', component: BudgetDetailsComponent, children: [
      {path: '', component: CategoriesComponent},
      {path: ':year/:month', component: CategoriesComponent}
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class BudgetRoutingModule {
}
