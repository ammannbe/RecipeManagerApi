import ApiClient from "./ApiClient";

export default interface Tag {
    id: number;
    name: string;
    slug: string;
}

export default class Tags extends ApiClient {
    protected url = "/tags";

    public async index(): Promise<Tag[]> {
        return super.index() as Promise<Tag[]>;
    }
}
