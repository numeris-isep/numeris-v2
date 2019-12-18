import * as moment from 'moment';

export function dateToISO(date: string) {
  return date ? moment(date).toISOString() : null;
}

export function dateToString(date: any) {
  return date ? moment(date).format('Y-MM-DD HH:mm:ss') : null;
}

export function equals(obj1: any, obj2) {
  return JSON.stringify(obj1) === JSON.stringify(obj2);
}
