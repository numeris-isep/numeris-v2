import { Mission } from "../models/mission";
import { Link } from "./link";
import { Meta } from "./meta";

export class PaginatedMission {

  data: Mission[];
  links: Link;
  meta: Meta;

}
