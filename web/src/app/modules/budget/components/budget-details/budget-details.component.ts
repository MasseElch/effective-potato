import { Component, OnDestroy, OnInit } from '@angular/core';
import { Subscription } from 'rxjs/Subscription';
import { ActivatedRoute, Router } from '@angular/router';
import { BudgetService } from '../../services/budget.service';
import { BudgetInterface } from '../../../../../codegen/budget';
import { Observable } from 'rxjs/Observable';
import { getMonth, getYear } from "date-fns";
import { FormControl } from '@angular/forms';

@Component({
  selector: 'efpo-budget-details',
  templateUrl: './budget-details.component.html',
  styleUrls: ['./budget-details.component.scss']
})
export class BudgetDetailsComponent implements OnInit, OnDestroy {

  routeParamSubscription: Subscription;

  budget: BudgetInterface;

  month: FormControl;

  constructor(private budgetService: BudgetService, private route: ActivatedRoute, private router: Router) { }

  ngOnInit() {
    // Fetch the budget data
    this.routeParamSubscription = this.route.params.subscribe(params => {
      this.budgetService.budgetDetails(params.id).subscribe(budget => {
        this.budget = budget;
      });

      // Initialize month picker and listen to changes
      const today = new Date();
      this.month = new FormControl({
        month: getMonth(today),
        year: getYear(today)
      });
      this.month.valueChanges.subscribe(value => {
        this.router.navigate(['budgets', params.id, value.year, value.month]);
      });
    });

  }

  ngOnDestroy(): void {
    this.routeParamSubscription.unsubscribe();
  }
}
