import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './core/components/login/login.component';

const routes: Routes = [
  // todo - dev
  {path: '', redirectTo: 'budgets', pathMatch: 'full'},

  {path: 'login', component: LoginComponent},

  {path: 'budgets', loadChildren: 'app/modules/budget/budget.module#BudgetModule'}

];

@NgModule({
  imports: [RouterModule.forRoot(routes, {paramsInheritanceStrategy: 'always'})],
  exports: [RouterModule]
})
export class AppRoutingModule { }
