export class Alert {
  type: AlertType;
  content: string;
  title: string | null = null;
  target: string;
}

export enum AlertType {
  Success,
  Info,
  Warning,
  Error,
}