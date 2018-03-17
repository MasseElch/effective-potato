import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { CategoriesView } from '../../../../codegen/categoriesView';
import { BudgetInterface } from '../../../../codegen/budget';
import { format, getYear } from 'date-fns';

@Injectable()
export class CategoryService {

  constructor(private http: HttpClient) {
  }

  categories(budgetId: number, year?: number, month?: number): Observable<CategoriesView> {
    if (year && month) {
      return this.http.get<CategoriesView>('/' + ['budgets', budgetId, 'categories', year, month].join('/'));
    }
    const date = new Date();
    return this.http.get<CategoriesView>('/' + ['budgets', budgetId, 'categories', getYear(date), format(date, 'M')].join('/'));
  }
}
