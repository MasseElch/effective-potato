import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { createNumberMask } from 'text-mask-addons/dist/textMaskAddons';
import { BudgetService, CategoryBudgets } from '../../services/budget.service';
import { ActivatedRoute } from '@angular/router';
import { Subscription } from 'rxjs/Subscription';
import { BudgetInterface } from '../../../../../codegen/budget';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/observable/forkJoin';

@Component({
  selector: 'efpo-categories',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.scss']
})
export class CategoriesComponent implements OnInit, OnDestroy {

  private _routeParamsSubscription: Subscription;

  budget: BudgetInterface;
  year: number;
  month: number;

  form: FormGroup;

  mask = createNumberMask({
    prefix: '',
    suffix: ' €',
    thousandsSeparatorSymbol: '.',
    allowDecimal: true,
    decimalSymbol: ','
  });

  constructor(private _budgetService: BudgetService, private _route: ActivatedRoute, private _fb: FormBuilder) {
  }

  ngOnInit(): void {
    this._routeParamsSubscription = this._route.params.subscribe(params => {
      Observable.forkJoin(
        this._budgetService.budgetDetails(params.id),
        this._budgetService.categoryBudgets(params.id, params.year, params.month)
      ).subscribe(([budget, categoryBudgets]: [BudgetInterface, CategoryBudgets]) => {
        this.budget = budget;
        this.year = params.year;
        this.month = params.month;
        this.form = this._fb.group(budget.categories.reduce((controls, category) => {
          const value = categoryBudgets[category.id] ? categoryBudgets[category.id].money.amount : 0;
          return {
            ...controls,
            [category.id]: value
          };
        }, {}));
      });
    });
  }

  ngOnDestroy(): void {
    this._routeParamsSubscription.unsubscribe();
  }

  update(): void {
    this._budgetService.updateCategoryBudget(this.budget.id, this.form.value, this.year, this.month).subscribe(
      (categoryBudgets: CategoryBudgets) => {

      },
      console.error // todo - error handling
    );
    console.log(this.form.value);
  }
}
