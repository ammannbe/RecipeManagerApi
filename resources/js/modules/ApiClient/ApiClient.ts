import axios, { AxiosInstance, AxiosResponse } from "axios";
import env from "../../env";
import LocalStorage from "../LocalStorage";

export default class ApiClient {
    private axios: AxiosInstance;
    protected url = "";

    constructor(authorize = true) {
        this.axios = axios.create({
            baseURL: env.APP_URL + "/api",
            withCredentials: true,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json",
                Accept: "application/json"
            }
        });
    }

    public async request(
        method: any,
        url: string,
        data?: object,
        headers?: object
    ): Promise<any> {
        let request: {};
        if (method === "get") {
            const params = data;
            request = { method, url, params, headers };
        } else {
            request = { method, url, data, headers };
        }
        return this.axios
            .request(request)
            .then(response => Promise.resolve(response.data))
            .catch(error => {
                if (
                    error.response.status == 403 ||
                    error.response.status == 401
                ) {
                    alert("Oopsii.. Diese Aktion ist leider nicht erlaubt :-(");
                }
                return Promise.reject(error.response);
            });
    }

    public get(url: string, data?: object): Promise<any> {
        return this.request("get", url, data);
    }

    public show(id?: number): Promise<any> {
        return this.get(`${this.url}/${id}`);
    }

    public index(filter?: object): Promise<any> {
        return this.get(`${this.url}`, filter);
    }

    public post(
        url: string,
        data?: object,
        hasFile: boolean = false
    ): Promise<any> {
        let headers;
        if (hasFile) {
            headers = { "Content-Type": "multipart/form-data" };
        }
        return this.request("post", url, data, headers);
    }

    public store(data: object, hasFile: boolean = false): Promise<any> {
        return this.post(`${this.url}`, data, hasFile);
    }

    public put(
        url: string,
        data: object,
        hasFile: boolean = false
    ): Promise<any> {
        let headers;
        if (hasFile) {
            headers = { "Content-Type": "multipart/form-data" };
        }
        return this.request("put", url, data, headers);
    }

    public bulkUpdate(
        id: number,
        data: object,
        hasFile: boolean = false
    ): Promise<any> {
        return this.put(`${this.url}/${id}`, data, hasFile);
    }

    public patch(
        url: string,
        key: string,
        value: string | number | boolean,
        hasFile: boolean = false
    ): Promise<any> {
        let headers;
        if (hasFile) {
            headers = { "Content-Type": "multipart/form-data" };
        }
        return this.request("patch", url, { [key]: value }, headers);
    }

    public update(
        id: number,
        key: string,
        value: string | number | boolean,
        hasFile: boolean = false
    ): Promise<any> {
        return this.patch(`${this.url}/${id}`, key, value, hasFile);
    }

    public delete(url: string, data?: object): Promise<any> {
        return this.request("delete", url, data);
    }

    public remove(id?: number): Promise<any> {
        return this.delete(`${this.url}/${id}`);
    }

    public restore(id?: number): Promise<any> {
        return this.post(`${this.url}/${id}/restore`);
    }
}
