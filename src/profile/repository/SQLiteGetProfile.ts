import { GetProfileRepository } from "Portfolio/Profile/Domain/GetProfileRepository";
import { Profile } from "Portfolio/Profile/Domain/Profile";

export class SQLiteGetProfile implements GetProfileRepository {
    getById(id: string): Promise<Profile> {
        throw new Error("Method not implemented.");
    }

}