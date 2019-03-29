import { User } from "../models/user";
import { Link } from "./link";
import { Meta } from "./meta";

export class PaginatedUser {

  data: User[];
  links: Link;
  meta: Meta;

}
