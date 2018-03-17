import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { AuthService } from '../../../core/services/auth.service';
import { BudgetInterface } from '../../../../codegen/budget';

@Injectable()
export class BudgetService {

  constructor(private http: HttpClient) {
  }

  budgets(): Observable<Array<BudgetInterface>> {
    return this.http.get<Array<BudgetInterface>>('/users/' + AuthService.user.id + '/budgets');
  }

  budgetDetails(id: number): Observable<BudgetInterface> {
    return this.http.get<BudgetInterface>('/budgets/' + id);
  }
}
