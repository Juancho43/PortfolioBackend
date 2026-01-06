import { Project } from 'Portfolio/Projects/Domain/Project';
import { Paginated } from 'Portfolio/Shared/Domain/Paginated';
import { ProjectRepository } from '../../../Portfolio/Projects/Domain/ProjectRepository';
import { Collection, Db, MongoClient, ObjectId } from 'mongodb';
import { ProjectMapper } from './ProjectMapper';

export class MongooseProjectRepository implements ProjectRepository {
  private db: Db;
  private collection: Collection;

  constructor() {
    // Inicializar conexión
    //this.initConnection().then();
  }

  private async initConnection() {
    const client = new MongoClient(
      process.env.MONGODB_URI || 'mongodb://localhost:27017',
    );
    await client.connect();
    this.db = client.db(process.env.DB_NAME || 'portfolio');
    this.collection = this.db.collection('projects');
  }

  async save(project: Project): Promise<void> {
    const projectData = ProjectMapper.buildProjectData(project);

    // Si tiene ID, hacer update, sino insert
    const id = project.id.getValue();

    if (id && ObjectId.isValid(id)) {
      // Update
      await this.collection.updateOne(
        { _id: new ObjectId(id) },
        { $set: projectData },
      );
    } else {
      // Insert nuevo
      await this.collection.insertOne(projectData);
    }
  }
  async delete(id: string): Promise<void> {
    await this.collection.updateOne(
      { _id: new ObjectId(id) },
      { $set: { softdelete: true } },
    );
  }
  async getById(id: string): Promise<Project | null> {
    if (!ObjectId.isValid(id)) return null;
    const data = await this.collection.findOne({
      _id: new ObjectId(id),
      softdelete: false,
    });
    return data ? ProjectMapper.mapToDomain(data) : null;
  }
  async getAll(page: number, limit: number): Promise<Project[]> {
    const skip = (page - 1) * limit;

    const data = await this.collection
      .find({ softdelete: false })
      .skip(skip)
      .limit(limit)
      .sort({ createdAt: -1 })
      .toArray();

    // Mapear a objetos de dominio
    return data.map((data) => ProjectMapper.mapToDomain(data));
  }
  async getBySlug(slug: string): Promise<Project | null> {
    const data = await this.collection.findOne({ slug, softdelete: false });
    return data ? ProjectMapper.mapToDomain(data) : null;
  }
  async getPinnedProjects(): Promise<Project[]> {
    const data = await this.collection
      .find({ pinned: true, softdelete: false })
      .sort({ createdAt: -1 })
      .toArray();

    return data.map((item) => ProjectMapper.mapToDomain(item));
  }
  async getByTag(paginated: Paginated, tag: string): Promise<Project[]> {
    const skip = (paginated.page - 1) * paginated.limit;
    const data = await this.collection
      .find({ tags: tag, softdelete: false })
      .skip(skip)
      .limit(paginated.limit)
      .sort({ createdAt: -1 })
      .toArray();

    return data.map((item) => ProjectMapper.mapToDomain(item));
  }
}
