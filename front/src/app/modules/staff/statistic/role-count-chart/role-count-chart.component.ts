import { Component, OnInit } from '@angular/core';
import { RoleService } from '../../../../core/http/role.service';
import { forkJoin, Observable } from 'rxjs';
import { Role } from '../../../../core/classes/models/role';
import { UserService } from '../../../../core/http/user.service';
import { PaginatedUser } from '../../../../core/classes/pagination/paginated-user';
import { RolePipe } from '../../../../shared/pipes/role.pipe';

@Component({
  selector: 'app-role-count-chart',
  templateUrl: './role-count-chart.component.html'
})
export class RoleCountChartComponent implements OnInit {

  configuration: any;

  roles: string[];
  data: number[];

  constructor(
    private roleService: RoleService,
    private rolePipe: RolePipe,
    private userService: UserService,
  ) { }

  ngOnInit() {
    this.getData();
  }

  configure() {
    this.configuration = {
      type: 'doughnut',
      data: {
        labels: this.roles,
        datasets: [{
          data: this.data,
          backgroundColor: [
            '#DB2828',
            '#FBBD08',
            '#A9D5DE',
            '#21BA45',
          ],
        }],
      },
      options: {
        cutoutPercentage: 60,
      }
    };
  }

  getData() {
    forkJoin([
      this.getRoles(),
      this.getDevelopers(),
      this.getAdministrators(),
      this.getStaffs(),
      this.getStudents(),
    ]).subscribe(data => {
      this.roles = data[0].map(role => this.rolePipe.transform(role));
      this.data = [
        data[1].meta.total,
        data[2].meta.total,
        data[3].meta.total,
        data[4].meta.total,
      ];

      this.configure();
    });
  }

  getRoles(): Observable<Role[]> {
    return this.roleService.getRoles();
  }

  getStudents(): Observable<PaginatedUser> {
    return this.userService.getPaginatedUsers(null, null, null, 'student');
  }

  getStaffs(): Observable<PaginatedUser> {
    return this.userService.getPaginatedUsers(null, null, null, 'staff');
  }

  getAdministrators(): Observable<PaginatedUser> {
    return this.userService.getPaginatedUsers(null, null, null, 'administrator');
  }

  getDevelopers(): Observable<PaginatedUser> {
    return this.userService.getPaginatedUsers(null, null, null, 'developer');
  }

}
