export default interface Errors {
    [key: string]: any;
}

export default class Errors {
    /**
     * Errors object
     */
    private errors = <Errors>{};

    /**
     * Create a new Errors instance.
     *
     * @param {Errors} errors
     */
    constructor(errors?: Errors) {
        if (!errors) {
            errors = {} as Errors;
        }
        this.record(errors);
    }

    /**
     * Get all the errors.
     *
     * @return {Errors}
     */
    public all(): Errors {
        return this.errors;
    }

    /**
     * Determine if any errors exists for the given key.
     *
     * @param {string} key
     * @return {boolean}
     */
    public has(key: string): boolean {
        if (!this.any()) {
            return false;
        }
        return this.errors.hasOwnProperty(key);
    }

    /**
     * Get the first item of field
     *
     * @param {string} key
     * @return {string|null}
     */
    public first(key: string): string | null {
        if (!this.any()) {
            return null;
        }
        return this.get(key)[0];
    }

    /**
     * Get all items by key
     *
     * @param {string} key
     * @return {string|string[]}
     */
    public get(key: string): string | string[] {
        if (!this.any()) {
            return [];
        }
        return this.errors[key] || [];
    }

    /**
     * Record the new errors.
     *
     * @param {Errors} errors
     * @return {void}
     */
    public record(errors: Errors): void {
        this.errors = errors;
    }

    /**
     * Determine if we have any errors.
     *
     * @return {boolean}
     */
    public any(): boolean {
        return Object.keys(this.errors || {}).length > 0;
    }

    /**
     * Clear a specific key or all errors.
     *
     * @param {string} key
     * @return {void}
     */
    public clear(key?: string): void {
        if (!this.any()) {
            return;
        }

        if (!key) {
            this.errors = <Errors>{};
            return;
        }

        const errors = Object.assign({}, this.errors);

        Object.keys(errors)
            .filter(e => e === key)
            .forEach(e => delete errors[e]);

        this.errors = errors;

        return;
    }
}
