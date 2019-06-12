export class TeamMember {

  firstName: string;
  lastName: string;
  position: string;
  facebookPageName: string;
  defaultImage: string;
  otherImage: string;

  constructor(
    firstName: string,
    lastName: string,
    position: string,
    facebookPageName: string,
    defaultImage: string = '../logos/numeris-blue-square.png',
    otherImage: string = null,
  ) {
    this.firstName = firstName;
    this.lastName = lastName;
    this.position = position;
    this.facebookPageName = facebookPageName;
    this.defaultImage = defaultImage;
    this.otherImage = otherImage;
  }
}
