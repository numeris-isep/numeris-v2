export class Alert {
  type: AlertType;
  content: string;
  title: string | null = null;
}

export enum AlertType {
  Success,
  Info,
  Warning,
  Error,
}
