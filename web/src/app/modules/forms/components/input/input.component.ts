import { ControlValueAccessor, DefaultValueAccessor, FormControl, NG_VALUE_ACCESSOR } from '@angular/forms';
import { Component, forwardRef, Input, ViewChild } from '@angular/core';

@Component({
  moduleId: module.id,
  providers: [{
    provide: NG_VALUE_ACCESSOR,
    useExisting: forwardRef(() => InputComponent),
    multi: true
  }],
  selector: 'efpo-input',
  templateUrl: './input.component.html',
  styleUrls: ['./input.component.scss']
})
export class InputComponent implements ControlValueAccessor {
  @ViewChild(DefaultValueAccessor)
  input: DefaultValueAccessor;

  @Input()
  label: string;

  @Input()
  type = 'text';

  @Input()
  placeholder: string;

  @Input()
  formControl: FormControl;

  writeValue(value: any): void {
    this.input.writeValue(value);
  }

  registerOnChange(fn: (_: any) => void): void {
    this.input.registerOnChange(fn);
  }

  registerOnTouched(fn: () => void): void {
    this.input.registerOnTouched(fn);
  }

  setDisabledState(isDisabled: boolean): void {
    this.input.setDisabledState(isDisabled);
  }
}
