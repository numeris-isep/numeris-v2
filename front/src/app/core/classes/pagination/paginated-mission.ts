import { Mission } from "../models/mission";
import { Link } from "./link";
import { Meta } from "./meta";
import { IPagination } from "./pagination-interface";

export class PaginatedMission implements IPagination {

  data: Mission[];
  links: Link;
  meta: Meta;

}
