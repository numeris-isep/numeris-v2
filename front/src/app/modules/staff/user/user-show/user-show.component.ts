import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from "@angular/router";
import { UserService } from "../../../../core/http/user.service";
import { TitleService } from "../../../../core/services/title.service";
import { BreadcrumbsService } from "../../../../core/services/breadcrumbs.service";
import { User } from "../../../../core/classes/models/user";

@Component({
  selector: 'app-user-show',
  templateUrl: './user-show.component.html',
  styleUrls: ['./user-show.component.css']
})
export class UserShowComponent implements OnInit {

  user: User;

  constructor(
    private route: ActivatedRoute,
    private userService: UserService,
    private titleService: TitleService,
    private breadcrumbService: BreadcrumbsService
  ) { }

  ngOnInit() {
    this.route.params.subscribe(param => {
      this.getUser(parseInt(param.id))
    });
  }

  getUser(userId: number) {
    return this.userService.getUser(userId).subscribe(user => {
        this.user = user;
        let name = 'Utilisateur sans nom';

        if (user.firstName && user.lastName) {
          name = `${user.firstName} ${user.lastName.toUpperCase()}`;
        }

        this.titleService.setTitles(name);
        this.breadcrumbService.setBreadcrumb(
          this.route.snapshot,
          { title: name, url: '' }
        )
    });
  }

}