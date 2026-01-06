import { User } from '../../User/Domain/User';
import { ProfileId } from './ValueObjects/ProfileId';
import { ProfileRole } from './ValueObjects/ProfileRol';
import { ProfileDescription } from './ValueObjects/ProfileDescription';
import { ProfileBio } from './ValueObjects/ProfileBio';
import { Timestamp } from '../../Shared/Domain/Timestamp';
import { SoftDelete } from '../../Shared/Domain/SoftDelete';
import { Link } from '../../Links/Domain/Link';
import { Education } from '../../Educations/Domain/Education';

import { Image } from '../../Images/Domain/Image';
import { File } from '../../Files/Domain/File';
import { Work } from '../../Works/Domain/Work';
import { ProfileName } from './ValueObjects/ProfileName';

export class Profile {
  private _id: ProfileId;
  private _name: ProfileName;
  private _rol: ProfileRole;
  private _description: ProfileDescription;
  private _bio: ProfileBio;
  private _links: Link[] = [];
  private _works: Work[] = [];
  private _educations: Education[] = [];
  private _photo: Image;
  private _cv: File;
  private _timestamp: Timestamp;
  private _softDelete: SoftDelete;
  private constructor(
    id: ProfileId,
    name: ProfileName,
    rol: ProfileRole,
    description: ProfileDescription,
    bio: ProfileBio,
    timestamp: Timestamp,
    softDelete: SoftDelete,
  ) {
    this._id = id;
    this._name = name;
    this._rol = rol;
    this._description = description;
    this._bio = bio;
    this._timestamp = timestamp;
    this._softDelete = softDelete;
  }

  public static create(
    id: ProfileId,
    name: ProfileName,
    rol: ProfileRole,
    bio: ProfileBio,
    description: ProfileDescription,
    timestamp: Timestamp,
    softDelete: SoftDelete,
  ): Profile {
    return new Profile(
      id,
      name,
      rol,
      description,
      bio,
      timestamp,
      softDelete,
    );
  }

  get id(): ProfileId {
    return this._id;
  }

  set id(value: ProfileId) {
    this._id = value;
  }
  get name(): ProfileName {
    return this._name;
  }
  set name(value: ProfileName) {
    this._name = value;
  }
  get rol(): ProfileRole {
    return this._rol;
  }

  set rol(value: ProfileRole) {
    this._rol = value;
  }

  get description(): ProfileDescription {
    return this._description;
  }

  set description(value: ProfileDescription) {
    this._description = value;
  }

  get bio(): ProfileBio {
    return this._bio;
  }

  set bio(value: ProfileBio) {
    this._bio = value;
  }

  get links(): Link[] {
    return this._links;
  }

  set links(value: Link[]) {
    this._links = value;
  }

  get works(): Work[] {
    return this._works;
  }

  set works(value: Work[]) {
    this._works = value;
  }

  get educations(): Education[] {
    return this._educations;
  }

  set educations(value: Education[]) {
    this._educations = value;
  }

  get photo(): Image {
    return this._photo;
  }

  set photo(value: Image) {
    this._photo = value;
  }

  get cv(): File {
    return this._cv;
  }

  set cv(value: File) {
    this._cv = value;
  }

  get timestamp(): Timestamp {
    return this._timestamp;
  }

  set timestamp(value: Timestamp) {
    this._timestamp = value;
  }

  get softDelete(): SoftDelete {
    return this._softDelete;
  }

  set softDelete(value: SoftDelete) {
    this._softDelete = value;
  }
}
