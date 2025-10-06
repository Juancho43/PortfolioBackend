import { TagRepository } from '../Domain/TagRepository';
import { Tag } from '../Domain/Tag';
import { TagTitle } from '../Domain/ValueObject/TagTitle';
import { GetTagById } from './GetTagById';
import { IUseCase } from '../../Shared/Application/IUseCase';
import { EditTagRequest } from './DTO/EditTagRequest';

export class EditTag implements IUseCase<EditTagRequest, Tag> {
  private repository: TagRepository;
  private getById: GetTagById;

  constructor(repository: TagRepository, getById: GetTagById) {
    this.repository = repository;
    this.getById = getById;
  }

  execute(data: EditTagRequest): Tag {
    const tag = this.getById.execute(data.id);
    tag.title = TagTitle.create(data.data.title);
    tag.timestamp = tag.timestamp.touch();
    this.repository.save(tag);
    return tag;
  }
}
