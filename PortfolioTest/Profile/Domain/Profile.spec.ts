import { Profile } from '../../../Portfolio/Profile/Domain/Profile';
import { ProfileId } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileId';
import { ProfileName } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileName';
import { ProfileRole } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileRol';
import { ProfileBio } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileBio';
import { ProfileDescription } from '../../../Portfolio/Profile/Domain/ValueObjects/ProfileDescription';
import { Timestamp } from '../../../Portfolio/Shared/Domain/Timestamp';
import { SoftDelete } from '../../../Portfolio/Shared/Domain/SoftDelete';
import { ProfileMother } from './ProfileMother';

describe('Profile Entity', () => {
  it('should create a profile instance using the static create method', () => {
    // Arrange
    const id = ProfileId.create('uuid-123');
    const name = ProfileName.create('John Doe');
    const rol = ProfileRole.create('Developer');
    const bio = ProfileBio.create('My bio');
    const description = ProfileDescription.create('My description');
    const timestamp = Timestamp.now();
    const softDelete = SoftDelete.no();

    // Act
    const profile = Profile.create(
      id,
      name,
      rol,
      bio,
      description,
      timestamp,
      softDelete,
    );

    // Assert
    expect(profile).toBeInstanceOf(Profile);
    expect(profile.id).toBe(id);
    expect(profile.name.name.getValue()).toBe('John Doe'); // Asumiendo que tus VO tienen .value
    expect(profile.softDelete.isSoftDeleted()).toBe(false);
  });

  it('should allow updating properties through setters', () => {
    // Arrange
    const profile = ProfileMother.create();
    const newName = ProfileName.create('Jane Doe');

    // Act
    profile.name = newName;

    // Assert
    expect(profile.name).toBe(newName);
    expect(profile.name.name.getValue()).toBe('Jane Doe');
  });
});
describe('Profile Entity Getters and Setters', () => {
  it('should update all fields using setters and retrieve them with getters', () => {
    // 1. Arrange: Creamos un perfil inicial aleatorio con el Mother
    const profile = ProfileMother.create();

    // Preparamos los nuevos valores
    const newName = ProfileName.create('Updated Name');
    const newRole = ProfileRole.create('Senior Architect');
    const newBio = ProfileBio.create('New biography content');
    const newLinks = []; // O instancias de Link

    // 2. Act: Usamos los setters
    profile.name = newName;
    profile.rol = newRole;
    profile.bio = newBio;
    profile.links = newLinks;
    // ... repetir para los demás campos si es necesario

    // 3. Assert: Verificamos con los getters
    expect(profile.name).toBe(newName);
    expect(profile.name.name.getValue()).toBe('Updated Name');

    expect(profile.rol).toBe(newRole);
    expect(profile.rol.role.getValue()).toBe('Senior Architect');

    expect(profile.bio).toBe(newBio);
    expect(profile.links).toEqual([]);
  });

  it('should correctly handle the softDelete status', () => {
    const profile = ProfileMother.create();

    // Por defecto el Mother lo crea en 'no'
    expect(profile.softDelete.isSoftDeleted()).toBe(false);

    // Act: Cambiamos el estado
    profile.softDelete = SoftDelete.yes();

    // Assert
    expect(profile.softDelete.isSoftDeleted()).toBe(true);
  });
});