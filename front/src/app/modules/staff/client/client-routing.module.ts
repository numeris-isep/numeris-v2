import { NgModule } from '@angular/core';
import { RouterModule, Routes } from "@angular/router";
import { ClientComponent } from "./client.component";
import { AuthGuard } from "../../../core/guards/auth.guard";
import { ClientIndexComponent } from "./client-index/client-index.component";
import { ClientShowComponent } from "./client-show/client-show.component";

const clientRoutes: Routes = [
  {
    path: 'clients',
    component: ClientComponent,
    canActivate: [AuthGuard],
    data: {
      title: 'Clients'
    },
    children: [
      {
        path: '',
        component: ClientIndexComponent,
      },
      {
        path: ':id',
        component: ClientShowComponent,
      }
    ]
  },
];

@NgModule({
  imports: [
    RouterModule.forChild(clientRoutes)
  ],
  exports: [RouterModule]
})
export class ClientRoutingModule { }
