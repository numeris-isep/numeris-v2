export class TeamMember {

  firstName: string;
  lastName: string;
  position: string;
  description: string;
  facebookPageName: string;
  defaultImage: string;
  otherImage: string;

  constructor(
    firstName: string,
    lastName: string,
    position: string,
    description: string,
    facebookPageName: string,
    defaultImage: string,
    otherImage: string
  ) {
    this.firstName = firstName;
    this.lastName = lastName;
    this.position = position;
    this.description = description;
    this.facebookPageName = facebookPageName;
    this.defaultImage = defaultImage + '.png';
    this.otherImage = otherImage + '.png';
  }
}
