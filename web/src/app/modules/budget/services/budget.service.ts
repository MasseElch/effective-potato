import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { AuthService } from '../../../core/services/auth.service';
import { BudgetInterface } from '../../../../codegen/budget';
import { BudgetedAtMonthInterface } from '../../../../codegen/budgetedAtMonth';
import 'rxjs/add/observable/of';
import 'rxjs/add/operator/share';
import 'rxjs/add/operator/do';
import { format, getYear } from 'date-fns';

export interface CategoryBudgets {
  [key: string]: BudgetedAtMonthInterface;
}

@Injectable()
export class BudgetService {

  private _budget$: { [key: number]: Observable<BudgetInterface> } = {};

  constructor(private http: HttpClient) {
  }

  budgets(): Observable<Array<BudgetInterface>> {
    return this.http.get<Array<BudgetInterface>>('/users/' + AuthService.user.id + '/budgets');
  }

  budgetDetails(id: number): Observable<BudgetInterface> {
    if (this._budget$[id]) {
      return this._budget$[id];
    }
    this._budget$[id] = this.http
      .get<BudgetInterface>('/budgets/' + id)
      .do(_ => this._budget$[id] = null)
      .share();

    return this._budget$[id];
  }

  categoryBudgets(
    budgetId: number,
    year: number = getYear(new Date()),
    month: number | string = format(new Date(), 'M')
  ): Observable<CategoryBudgets> {
    return this.http.get<CategoryBudgets>('/' + ['budgets', budgetId, 'categories', year, month].join('/'));
  }

  updateCategoryBudget(
    budgetId: number,
    data: CategoryBudgets,
    year: number = getYear(new Date()),
    month: number | string = format(new Date(), 'M'),
  ): Observable<CategoryBudgets> {
    console.log(data);
    return this.http.put<CategoryBudgets>(
      '/' + ['budgets', budgetId, 'categories', year, month].join('/'),
      data
    );
  }
}
