import { NgModule } from '@angular/core';
import { InputComponent } from './components/input/input.component';
import { FormsModule as AngularFormsModule, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { SelectTextOnFocusDirective } from './directives/select-text-on-focus.directive';

@NgModule({
  imports: [
    CommonModule,

    AngularFormsModule, ReactiveFormsModule,
  ],
  declarations: [
    InputComponent,
    SelectTextOnFocusDirective
  ],
  exports: [
    AngularFormsModule, ReactiveFormsModule,

    InputComponent,
    SelectTextOnFocusDirective
  ]
})
export class FormsModule {
}
