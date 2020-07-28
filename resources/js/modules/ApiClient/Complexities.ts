import ApiClient from "./ApiClient";

export interface Complexity {
    id: string;
    name: string;
}

export default class Complexities extends ApiClient {
    public async index(): Promise<Complexity[]> {
        return Promise.resolve(<Complexity[]>[
            {
                id: "simple",
                name: "Einfach"
            },
            {
                id: "normal",
                name: "Mittel"
            },
            {
                id: "difficult",
                name: "Schwierig"
            }
        ]);
    }
}
