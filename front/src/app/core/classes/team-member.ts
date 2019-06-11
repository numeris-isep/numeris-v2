export class TeamMember {

  firstName: string;
  lastName: string;
  position: string;
  facebookPageName: string;
  defaultImage: string;
  show: boolean;

  constructor(
    firstName: string,
    lastName: string,
    position: string,
    facebookPageName: string,
    defaultImage: string
  ) {
    this.firstName = firstName;
    this.lastName = lastName;
    this.position = position;
    this.facebookPageName = facebookPageName;
    this.defaultImage = defaultImage;
  }
}
