import { faker } from '@faker-js/faker';
import { Profile } from '../../../Portfolio/Profile/Domain/Profile';
import { ProfileId } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileId';
import { ProfileName } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileName';
import { ProfileRole } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileRol';
import { ProfileBio } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileBio';
import { ProfileDescription } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileDescription';
import { Timestamp } from '../../../Portfolio/Shared/Domain/Timestamp';
import { SoftDelete } from '../../../Portfolio/Shared/Domain/SoftDelete';

export class ProfileMother {
  static create(
    overrides: Partial<{
      id: string;
      name: string;
      role: string;
      bio: string;
      description: string;
    }> = {},
  ): Profile {
    return Profile.create(
      ProfileId.create(overrides.id ?? faker.string.uuid()),
      ProfileName.create(overrides.name ?? faker.person.fullName()),
      ProfileRole.create(overrides.role ?? faker.person.jobTitle()),
      ProfileBio.create(overrides.bio ?? faker.lorem.sentence()),
      ProfileDescription.create(
        overrides.description ?? faker.lorem.paragraph(),
      ),
      Timestamp.now(),
      SoftDelete.no(),
    );
  }

  /**
   * Crea una lista de perfiles aleatorios
   */
  static createMany(count: number = 3): Profile[] {
    return Array.from({ length: count }, () => this.create());
  }

  /**
   * Crea un perfil con datos muy específicos para casos de error o validación
   */
  static createWithLongDescription(): Profile {
    return this.create({
      description: faker.lorem.paragraphs(5),
    });
  }
}
