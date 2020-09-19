import ApiClient from "./ApiClient";
import { Author } from "./Authors";
import { Cookbook } from "./Cookbooks";
import { Category } from "./Categories";
import { Complexity } from "./Complexities";

export interface Recipe {
    id: number;
    cookbook_id: number;
    cookbook: Cookbook;
    category_id: number;
    category: Category;
    author_id: number;
    author: Author;
    name: string;
    yield_amount: number;
    complexity: Complexity;
    instructions: string;
    preparation_time: string;
    photos: File[];
    photo_urls: string[];
}

export default class Recipes extends ApiClient {
    protected url = "/recipes";
    protected rawResponse: boolean;

    constructor(rawResponse = false) {
        super();
        this.rawResponse = rawResponse;
    }

    public async index(filter?: object): Promise<Recipe[]> {
        return super.index(filter) as Promise<Recipe[]>;
    }

    public async show(id: number): Promise<any> {
        return super.show(id) as Promise<any>;
    }

    public async store(data: Recipe): Promise<any> {
        let formData: any;
        if (data.photos) {
            formData = new FormData();
            Object.keys(data).forEach(key => {
                const value: string | null | [] = (<any>data)[key];

                if (value instanceof Array && value.length > 0) {
                    value.forEach((v: any, i: number) => {
                        formData.append(`${key}[${i}]`, v);
                    });
                    return;
                }

                formData.append(key, value);
                return;
            });
        }
        return super.store(formData || data, !!data.photos.length);
    }

    public bulkUpdate(id: number, data: any): Promise<any> {
        let formData: any;
        if (data.photos && data.photos.length) {
            formData = new FormData();
            Object.keys(data).forEach(key => {
                const value: string | null | [] = (<any>data)[key];

                if (value instanceof Array && value.length > 0) {
                    value.forEach((v: any, i: number) => {
                        formData.append(`${key}[${i}]`, v);
                    });
                    return;
                }

                formData.append(key, value);
                return;
            });
        }
        return super.bulkUpdate(id, formData || data, !!data.photos.length);
    }

    public addPhotos(id: number, photos: Array<File>): Promise<any> {
        let formData = new FormData();
        photos.forEach(file => formData.append("photos[]", file));
        const url = `${this.url}/${id}/photos`;
        return this.post(url, formData, true);
    }

    public removePhoto(id: number, photo: string): Promise<any> {
        const url = `${this.url}/${id}/photos/${photo}`;
        return this.delete(url);
    }

    public async pdf(id: number): Promise<any> {
        const data = await super.get(
            `${this.url}/${id}/pdf`,
            undefined,
            "blob"
        );
        return window.URL.createObjectURL(new Blob([data]));
    }
}
