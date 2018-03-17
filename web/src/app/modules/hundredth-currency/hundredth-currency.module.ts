import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HundredthCurrencyPipe } from './pipes/hundredth-currency.pipe';

@NgModule({
  imports: [CommonModule],
  declarations: [HundredthCurrencyPipe],
  exports: [HundredthCurrencyPipe]
})
export class HundredthCurrencyModule { }
