import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from "@angular/router";
import { ProjectComponent } from "./project.component";
import { AuthGuard } from "../../../core/guards/auth.guard";
import { ProjectIndexComponent } from "./project-index/project-index.component";
import { ProjectShowComponent } from "./project-show/project-show.component";

const projectRoutes: Routes = [
  {
    path: 'projects',
    component: ProjectComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Projects',
    },
    children: [
      {
        path: '',
        component: ProjectIndexComponent,
      },
      {
        path: ':id',
        component: ProjectShowComponent,
      },
    ]
  },
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(projectRoutes)
  ],
  exports: [RouterModule]
})
export class ProjectRoutingModule { }
