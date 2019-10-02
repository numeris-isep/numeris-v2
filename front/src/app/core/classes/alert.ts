import { TransitionController } from 'ng2-semantic-ui';

export class Alert {
  type: AlertType;
  content: string[];
  title: string | null = null;
  target: string;
  transitionController: TransitionController;
  dismissable: boolean = false;
}

export enum AlertType {
  Success,
  Info,
  Warning,
  Error,
}
