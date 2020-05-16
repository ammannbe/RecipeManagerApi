export default class RouteQueryHelper {
    public static pushOrReplace(
        query: any,
        key: string,
        value: any
    ): object {
        const newQuery: any = {};
        Object.keys(query).forEach(key => {
            newQuery[key] = query[key];
        });
        newQuery[key] = value;

        return newQuery;
    }

    public static remove(query: any, key: string) {
        const newQuery: any = {};
        Object.keys(query).forEach(i => {
            if (i != key) newQuery[i] = query[i];
        });

        return newQuery;
    }
}
