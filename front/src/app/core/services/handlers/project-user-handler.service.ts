import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { User } from '../../classes/models/user';
import { UserService } from '../../http/user.service';
import { Project } from '../../classes/models/project';

@Injectable({
  providedIn: 'root'
})
export class ProjectUserHandlerService {

  private $projectUsers: BehaviorSubject<User[]> = new BehaviorSubject<User[]>([]);
  private projectUsers: User[];

  constructor(private userService: UserService) { }

  getProjectUsersSubject(): BehaviorSubject<User[]> {
    return this.$projectUsers;
  }

  watchProjectUsers(project: Project) {
    this.userService.getProjectUsers(project).subscribe(users => {
      this.$projectUsers.next(users);
      this.projectUsers = this.$projectUsers.getValue();
    });
  }

  addProjectUser(user: User) {
    this.projectUsers = [...this.projectUsers, user];
    this.$projectUsers.next(this.projectUsers);
  }

  removeProjectUser(user: User) {
    this.projectUsers = this.projectUsers.filter(u => u.id !== user.id);
    this.$projectUsers.next([...this.projectUsers]);
  }

  resetAll() {
    this.$projectUsers.unsubscribe();
    this.$projectUsers = new BehaviorSubject<User[]>([]);
  }
}
