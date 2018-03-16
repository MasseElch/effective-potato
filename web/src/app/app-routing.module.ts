import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './components/login/login.component';
import { BudgetsComponent } from './components/budgets/budgets.component';

const routes: Routes = [
  // todo - dev
  {path: '', redirectTo: 'budgets', pathMatch: 'full'},

  {path: 'login', component: LoginComponent},

  {path: 'budgets', component: BudgetsComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
