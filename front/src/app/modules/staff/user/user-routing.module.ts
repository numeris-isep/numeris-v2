import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from "@angular/router";
import { UserComponent } from "./user.component";
import { AuthGuard } from "../../../core/guards/auth.guard";
import { UserIndexComponent } from "./user-index/user-index.component";
import { UserShowComponent } from "./user-show/user-show.component";

const userRoutes: Routes = [
  {
    path: 'utilisateurs',
    component: UserComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Utilisateurs',
    },
    children: [
      {
        path: '',
        component: UserIndexComponent,
      },
      {
        path: ':userId',
        component: UserShowComponent,
      }
    ]
  },
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(userRoutes)
  ],
  exports: [RouterModule]
})
export class UserRoutingModule { }
