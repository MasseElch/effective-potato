import { Component, OnDestroy, OnInit } from '@angular/core';
import { CategoryService } from '../../services/category.service';
import { ActivatedRoute } from '@angular/router';
import { Subscription } from 'rxjs/Subscription';
import { CategoriesView } from '../../../../../codegen/categoriesView';
import { Observable } from 'rxjs/Observable';
import { FormBuilder, FormGroup } from '@angular/forms';
import { createNumberMask } from 'text-mask-addons/dist/textMaskAddons';

@Component({
  selector: 'efpo-categories',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.scss']
})
export class CategoriesComponent implements OnInit, OnDestroy {

  routeParamSubscription: Subscription;

  categoriesView: CategoriesView;
  currentMoneyForm: FormGroup;
  moneyAtMonthsForm: FormGroup;

  mask = createNumberMask({
    prefix: '',
    suffix: ' €',
    thousandsSeparatorSymbol: '.',
    allowDecimal: true,
    decimalSymbol: ','
  });

  constructor(private categoryService: CategoryService, private route: ActivatedRoute, private fb: FormBuilder) {
  }

  ngOnInit() {
    this.routeParamSubscription = this.route.params.subscribe(params => {
      this.categoryService.categories(params.id, params.year, params.month).subscribe(categoriesView => {
        this.categoriesView = categoriesView;
        this.currentMoneyForm = this.fb.group(categoriesView.categories.reduce((controls, category) => {
          return {...controls, [category.id]: category.money.amount};
        }, {}));
        this.moneyAtMonthsForm = this.fb.group(categoriesView.categories.reduce((controls, category) => {
          return {
            ...controls,
            [category.id]: categoriesView.categoryBudgetedAtMonths[category.id].money.amount
          };
        }, {}));
      });
    });
  }

  ngOnDestroy(): void {
    this.routeParamSubscription.unsubscribe();
  }
}
