import { Input } from "@angular/core";

export class Button {

  @Input() visibleContent: string;
  @Input() visibleIcon: string;
  @Input() hiddenIcon: string;

  @Input() color: string = 'primary';
  @Input() size: string = 'large';
  @Input() animation: string = ''; // 'animated', 'vertical animated' or 'fade animated'
  @Input() attachment: string = ''; // '', 'top attached' or 'bottom attached'
  @Input() behaviour: string = ''; // '' or 'fluid'

  classes: string[];

}
