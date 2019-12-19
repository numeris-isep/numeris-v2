import { equals } from '../../shared/utils';

export const handleFormDeactivation = (component: any, formKey: string): boolean => {
  try {
    return component.submitted || equals(
      component.initialValue,
      component[formKey].value
    );
  } catch (e) {
    return true;
  }
};
