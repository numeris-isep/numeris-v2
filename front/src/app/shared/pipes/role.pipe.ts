import { Pipe, PipeTransform } from '@angular/core';
import { Role } from '../../core/classes/models/role';

@Pipe({
  name: 'role'
})
export class RolePipe implements PipeTransform {

  transform(role: Role, args?: any): string | null {
    if (role != null) {
      const translationFR = {
        developer: 'Développeur',
        administrator: 'Administrateur',
        staff: 'Staff',
        student: 'Étudiant'
      };

      return translationFR[role.name];
    }

    return null;
  }

}
