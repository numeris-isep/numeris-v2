import { Injectable } from '@angular/core';
import { User } from '../classes/models/user';
import { Task } from '../classes/task';

@Injectable({
  providedIn: 'root'
})
export class TasksService {

  tasks: Task[];

  constructor() { }

  getStudentTasks(user: User): Task[] {
    this.tasks = [];

    if (! user.touAccepted) {
      this.addTask({
        icon: 'book',
        title: 'Conditions d\'utilisations',
        description: 'Veuillez accepter les conditions d\'utilisations',
        link: '/conditions-dutilisation',
      });
    }

    if (! user.emailVerifiedAt) {
      this.addTask({
        icon: 'envelope',
        title: 'Adresse email',
        description: 'Veuillez vérifier votre adresse email',
        link: '/profil',
      });
    }

    if (
      !user.phone || !user.birthCity || !user.nationality
      || !user.socialInsuranceNumber || !user.bic
    ) {
      this.addTask({
        icon: 'edit',
        title: 'Informations du profil',
        description: 'Veuillez compléter votre profil',
        link: '/profil/modifier',
      });
    }

    return this.tasks;
  }

  addTask(task: Task) {
    this.tasks.push(task);
  }
}
