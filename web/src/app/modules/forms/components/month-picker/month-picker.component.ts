import { Component, ElementRef, forwardRef, Input, Renderer2, ViewChild } from '@angular/core';
import { ControlValueAccessor, NG_VALUE_ACCESSOR } from '@angular/forms';
import { addMonths, getMonth, getYear, subMonths, subYears } from 'date-fns';

@Component({
  selector: 'efpo-month-picker',
  providers: [{
    provide: NG_VALUE_ACCESSOR,
    useExisting: forwardRef(() => MonthPickerComponent),
    multi: true
  }],
  templateUrl: './month-picker.component.html',
  styleUrls: ['./month-picker.component.scss']
})
export class MonthPickerComponent implements ControlValueAccessor {

  readonly defaultRange = 6;

  @ViewChild('month') month: ElementRef;
  @ViewChild('year') year: ElementRef;

  @Input() years = Array.from(Array(this.defaultRange), (_, i) => i + getYear(subYears(new Date(), this.defaultRange / 2)));

  months = Array.from(Array(12), (_, i) => new Date(null, i));

  _value = {month: 0, year: 2017};

  constructor(private _renderer: Renderer2) {
  }

  nextMonth(): void {
    const next = addMonths(new Date(this._value.year, this._value.month), 1);
    this._value = {year: getYear(next), month: getMonth(next)};
    this.onChange(this._value);
  }

  previousMonth(): void {
    const previous = subMonths(new Date(this._value.year, this._value.month), 1);
    this._value = {year: getYear(previous), month: getMonth(previous)};
    this.onChange(this._value);
  }

  today(): void {
    const now = new Date();
    this._value = {year: getYear(now), month: getMonth(now)};
    this.onChange(this._value);
  }

  monthChange(value: any) {
    this._value.month = value;
    this.onChange(this._value);
  }

  yearChange(value: any) {
    this._value.year = value;
    this.onChange(this._value);
  }

  onChange = (_: any) => {};
  onTouched = () => {};

  writeValue(value: any): void {
    this._value = value == null ? {month: getMonth(new Date()), year: getYear(new Date())} : value;
  }

  registerOnChange(fn: (_: any) => void): void { this.onChange = fn; }
  registerOnTouched(fn: () => void): void { this.onTouched = fn; }

  setDisabledState(isDisabled: boolean): void {
    this._renderer.setProperty(this.month.nativeElement, 'disabled', isDisabled);
    this._renderer.setProperty(this.year.nativeElement, 'disabled', isDisabled);
  }
}
