import { Component, OnDestroy, OnInit } from '@angular/core';
import { Subscription } from 'rxjs/Subscription';
import { ActivatedRoute } from '@angular/router';
import { BudgetService } from '../../services/budget.service';
import { BudgetInterface } from '../../../../../codegen/budget';
import { Observable } from 'rxjs/Observable';

@Component({
  selector: 'efpo-budget-details',
  templateUrl: './budget-details.component.html',
  styleUrls: ['./budget-details.component.scss']
})
export class BudgetDetailsComponent implements OnInit, OnDestroy {

  routeParamSubscription: Subscription;

  budget$: Observable<BudgetInterface>;

  constructor(private budgetService: BudgetService, private route: ActivatedRoute) { }

  ngOnInit() {
    this.routeParamSubscription = this.route.params.subscribe(params => {
      this.budget$ = this.budgetService.budgetDetails(params.id);
    });
  }

  ngOnDestroy(): void {
    this.routeParamSubscription.unsubscribe();
  }
}
