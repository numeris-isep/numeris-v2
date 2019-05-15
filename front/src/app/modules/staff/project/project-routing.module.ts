import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from "@angular/router";
import { ProjectComponent } from "./project.component";
import { AuthGuard } from "../../../core/guards/auth.guard";
import { ProjectIndexComponent } from "./project-index/project-index.component";
import { ProjectShowComponent } from "./project-show/project-show.component";
import { ProjectCreateComponent } from "./project-create/project-create.component";
import { ProjectEditComponent } from "./project-edit/project-edit.component";
import { ProjectMissionCreateComponent } from "./project-mission-create/project-mission-create.component";

const projectRoutes: Routes = [
  {
    path: 'projets',
    component: ProjectComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Projets',
    },
    children: [
      {
        path: '',
        component: ProjectIndexComponent,
      },
      {
        path: 'nouveau',
        component: ProjectCreateComponent,
        data: {
          title: 'Nouveau projet'
        }
      },
      {
        path: ':projectId/modifier',
        component: ProjectEditComponent,
      },
      {
        path: ':projectId/missions/nouvelle',
        component: ProjectMissionCreateComponent,
      },
      {
        path: ':projectId',
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
