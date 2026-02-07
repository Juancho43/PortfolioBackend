import { Migration } from '@mikro-orm/migrations';

export class Migration20260119170424 extends Migration {

  override async up(): Promise<void> {
    this.addSql(`create table \`profiles\` (\`id\` text not null, \`name\` text not null, \`role\` text not null, \`description\` text not null, \`bio\` text not null, \`created_at\` datetime not null, \`updated_at\` datetime not null, \`deleted_at\` integer not null default false, primary key (\`id\`));`);
  }

}
