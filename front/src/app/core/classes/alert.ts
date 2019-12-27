import { TransitionController } from 'ng2-semantic-ui';

export class Alert {
  type: AlertType;
  content: string[];
  title: string | null = null;
  target: string;
  icon: boolean = false;
  transitionController: TransitionController;
}

export enum AlertType {
  Success,
  Info,
  Warning,
  Error,
}
