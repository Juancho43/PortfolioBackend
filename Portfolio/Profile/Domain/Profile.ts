import { User } from '../../User/Domain/User';
import { ProfileId } from './ValueObjects/ProfileId';
import { ProfileRol } from './ValueObjects/ProfileRol';
import { ProfileDescription } from './ValueObjects/ProfileDescription';
import { ProfileBio } from './ValueObjects/ProfileBio';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { Link } from '../../Links/Domain/Link';
import { Education } from '../../Educations/Domain/Education';

import { Image } from '../../Images/Domain/Image';
import { File } from '../../Files/Domain/File';
import { Work } from '../../Works/Domain/Work';

export class Profile {
  private id: ProfileId;
  private user: User;
  private rol: ProfileRol;
  private description: ProfileDescription;
  private bio: ProfileBio;
  private links: Link[];
  private works: Work[];
  private educations: Education[];
  private photo: Image;
  private cv: File;
  private timestamp: Timestamp;
  private softDelete: SoftDelete;
  private constructor(
    id: ProfileId,
    user: User,
    rol: ProfileRol,
    description: ProfileDescription,
    bio: ProfileBio,
    links: Link[],
    works: Work[],
    educations: Education[],
    photo: Image,
    cv: File,
    timestamp: Timestamp,
    softDelete: SoftDelete,
  ) {
    this.id = id;
    this.user = user;
    this.rol = rol;
    this.description = description;
    this.bio = bio;
    this.links = links;
    this.works = works;
    this.educations = educations;
    this.photo = photo;
    this.cv = cv;
    this.timestamp = timestamp;
    this.softDelete = softDelete;
  }

  /**
   * Static factory method to create a new Profile instance.
   * This is the only way to create a Profile.
   */
  public static create(
    id: ProfileId,
    user: User,
    rol: ProfileRol,
    description: ProfileDescription,
    bio: ProfileBio,
    links: Link[],
    works: Work[],
    educations: Education[],
    photo: Image,
    cv: File,
  ): Profile {
    return new Profile(
      id,
      user,
      rol,
      description,
      bio,
      links,
      works,
      educations,
      photo,
      cv,
      Timestamp.now(),
      SoftDelete.no(),
    );
  }

}
