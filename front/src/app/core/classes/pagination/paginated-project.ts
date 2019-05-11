import { Project } from "../models/project";
import { Link } from "./link";
import { Meta } from "./meta";
import { IPagination } from "./pagination-interface";

export class PaginatedProject implements IPagination {

  data: Project[];
  links: Link;
  meta: Meta;

}
