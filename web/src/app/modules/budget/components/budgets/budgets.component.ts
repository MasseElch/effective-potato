import { Component, OnInit } from '@angular/core';
import { BudgetService } from '../../services/budget.service';
import { Observable } from 'rxjs/Observable';
import { BudgetInterface } from '../../../../../codegen/budget';

@Component({
  selector: 'efpo-budgets',
  templateUrl: './budgets.component.html',
  styleUrls: ['./budgets.component.scss']
})
export class BudgetsComponent implements OnInit {

  budgets$: Observable<Array<BudgetInterface>>;

  constructor(private budgetService: BudgetService) { }

  ngOnInit() {
    this.budgets$ = this.budgetService.budgets();
  }
}
