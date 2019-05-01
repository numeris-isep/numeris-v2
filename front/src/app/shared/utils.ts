import * as moment from "moment";

export function dateToISO(date: string) {
  return date ? moment(date).toISOString() : null;
}

export function dateToString(date: any) {
  return date ? moment(date).format('Y-MM-DD HH:mm:ss') : null;
}
