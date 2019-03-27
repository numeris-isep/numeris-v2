import { Project } from "../models/project";
import { Link } from "./link";
import { Meta } from "./meta";

export class PaginatedProject {

  data: Project[];
  links: Link;
  meta: Meta;

}
