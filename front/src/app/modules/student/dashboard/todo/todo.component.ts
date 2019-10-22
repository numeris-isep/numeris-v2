import { Component, Input, OnInit } from '@angular/core';
import { User } from '../../../../core/classes/models/user';
import { Task } from 'src/app/core/classes/dashboard/Task';
import { TasksService } from '../../../../core/services/tasks.service';

@Component({
  selector: 'app-todo',
  templateUrl: './todo.component.html',
  styleUrls: ['./todo.component.css']
})
export class TodoComponent implements OnInit {

  @Input() user: User;
  tasks: Task[] = [];

  loading: boolean = false;

  constructor(private tasksService: TasksService) { }

  ngOnInit() {
    this.getTasks();
  }

  getTasks() {
    this.tasks = this.tasksService.getStudentTasks(this.user);
  }

}
