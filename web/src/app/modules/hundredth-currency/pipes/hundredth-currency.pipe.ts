import { Pipe, PipeTransform } from '@angular/core';
import { CurrencyPipe } from '@angular/common';
import { MoneyInterface } from '../../../../codegen/money';

@Pipe({
  name: 'hundredthCurrency'
})
export class HundredthCurrencyPipe extends CurrencyPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    return super.transform(value.amount / 100, value.currency, args);
  }

}
