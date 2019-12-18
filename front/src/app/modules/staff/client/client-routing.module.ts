import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ClientComponent } from './client.component';
import { AuthGuard } from '../../../core/guards/auth.guard';
import { ClientIndexComponent } from './client-index/client-index.component';
import { ClientShowComponent } from './client-show/client-show.component';
import { ClientCreateComponent } from './client-create/client-create.component';
import { ClientEditComponent } from './client-edit/client-edit.component';
import { ClientProjectCreateComponent } from './client-project-create/client-project-create.component';
import { ContactCreateComponent } from './contact-create/contact-create.component';
import { ContactEditComponent } from './contact-edit/contact-edit.component';
import { ConventionCreateComponent } from './convention-create/convention-create.component';
import { ConventionEditComponent } from './convention-edit/convention-edit.component';
import { DeactivateGuard } from '../../../core/guards/deactivate.guard';

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
        path: 'nouveau',
        component: ClientCreateComponent,
        canDeactivate: [DeactivateGuard],
        data: {
          title: 'Nouveau client'
        }
      },
      {
        path: 'contacts',
        data: {
          tab: 'contacts',
          title: 'Contacts',
        },
        children: [
          {
            path: '',
            component: ClientIndexComponent,
          },
          {
            path: 'nouveau',
            component: ContactCreateComponent,
            canDeactivate: [DeactivateGuard],
            data: {
              title: 'Nouveau contact client'
            },
          },
          {
            path: ':contactId/modifier',
            component: ContactEditComponent,
            canDeactivate: [DeactivateGuard],
          }
        ]
      },
      {
        path: ':clientId/modifier',
        component: ClientEditComponent,
        canDeactivate: [DeactivateGuard]
      },
      {
        path: ':clientId/projets/nouveau',
        component: ClientProjectCreateComponent,
        canDeactivate: [DeactivateGuard],
      },
      {
        path: ':clientId/conventions/:conventionId/modifier',
        component: ConventionEditComponent,
        canDeactivate: [DeactivateGuard],
      },
      {
        path: ':clientId/conventions/nouvelle',
        component: ConventionCreateComponent,
        canDeactivate: [DeactivateGuard],
      },
      {
        path: ':clientId/conventions',
        component: ClientShowComponent,
        data: {
          tab: 'conventions'
        }
      },
      {
        path: ':clientId',
        component: ClientShowComponent,
      },
    ]
  },
  {
    path: 'contacts',
    redirectTo: '/clients/contacts',
    pathMatch: 'full'
  },
];

@NgModule({
  imports: [
    RouterModule.forChild(clientRoutes)
  ],
  exports: [RouterModule]
})
export class ClientRoutingModule { }
