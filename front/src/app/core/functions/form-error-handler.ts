import { FormGroup } from "@angular/forms";

export const handleFormErrors = (form: FormGroup, errors: object) => {
  for (let key of Object.keys(errors)) {
    if (form.get(key)) {
      form.get(key).setErrors(errors[key]);
    } else {
      form.setErrors(errors[key]);
    }
  }
};
