import { LinkResponse } from '../../../../Portfolio/Links/Application/DTO/LinkResponse';
import { LinkMother } from '../../Domain/LinkMother'; // Asumiendo que tienes un Mother para Link

describe('LinkResponse', () => {
  it('should map a Link entity to a plain response object', () => {
    // Arrange
    const presenter = new LinkResponse();
    const link = LinkMother.create(); // Entidad con datos predecibles

    // Act
    const result = presenter.generate(link);

    // Assert
    expect(result).toEqual({
      id: link.id.id.getValue(),
      title: link.title.value.getValue(),
      url: link.url.value,
      createdAt: link.timestamp.getCreatedAt(),
      updatedAt: link.timestamp.getUpdatedAt(),
      deletedAt: link.softdelete.getDeletedAt(),
    });
  });

  it('should handle null values in soft delete if applicable', () => {
    const presenter = new LinkResponse();
    const link = LinkMother.create();
    // Forzamos que el softdelete devuelva null para asegurar que no rompa el mapper
    jest.spyOn(link.softdelete, 'getDeletedAt').mockReturnValue(null);

    const result = presenter.generate(link);

    expect(result.deletedAt).toBeNull();
  });
});
