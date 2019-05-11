import { User } from "../models/user";
import { Link } from "./link";
import { Meta } from "./meta";
import { IPagination } from "./pagination-interface";

export class PaginatedUser implements IPagination {

  data: User[];
  links: Link;
  meta: Meta;

}
