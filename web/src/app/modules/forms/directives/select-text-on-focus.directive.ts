import { Directive, ElementRef, HostListener } from '@angular/core';

@Directive({
  selector: '[efpoSelectTextOnFocus]'
})
export class SelectTextOnFocusDirective {

  @HostListener('focus') onFocus() {
    this.elementRef.nativeElement.select();
  }

  constructor(private elementRef: ElementRef) {
  }

}
