import Errors from "./Errors";

export default interface FormData {
    [key: string]: any;
}

export default class Form {
    /** @var {FormData} */
    private _originalData = <FormData>{};
    /** @var {FormData} */
    public _data = <FormData>{};
    /** @var {Errors} */
    private _errors = <Errors>{};

    /**
     * Create a new Form instance.
     *
     * @param {FormData} data
     */
    constructor(data: FormData) {
        this._originalData = data;

        for (let field in data) {
            this._data[field] = data[field];
        }

        this._errors = new Errors();
    }

    /**
     * Fetch all relevant data for the form.
     *
     * @return {FormData}
     */
    public get data(): FormData {
        let data = <FormData>{};

        for (let property in this._originalData) {
            data[property] = this._data[property];
        }

        return data;
    }

    /**
     * Get the data of a specific property.
     *
     * @param {string} property
     */
    public get(property: string) {
        return this._data[property];
    }

    /**
     * Set the data of a specific property.
     *
     * @param {string} property
     * @param {any} value
     */
    public set(property: string, value: any) {
        this._errors.clear(property);
        this._data[property] = value;
    }

    /**
     * Push new item to array
     *
     * @param {string} property
     * @param {any} value
     */
    public push(property: string, value: any) {
        this._errors.clear(property);
        this._data[property].push(value);
    }

    /**
     * replace new item to array
     *
     * @param {string} property
     * @param {any} index
     * @param {any} value
     */
    public replace(property: string, index: any, value: any) {
        this._errors.clear(property);
        this._data[property][index] = value;
    }

    /**
     * Remove item from array
     *
     * @param {string} property
     * @param {any} value
     */
    public remove(property: string, value: any) {
        const index = this._data[property].indexOf(value);
        this._data[property].splice(index, 1);
    }

    /**
     * Fetch all errors for the form.
     *
     * @return {Errors}
     */
    public get errors(): Errors {
        return this._errors;
    }

    /**
     * Reset the form fields.
     *
     * @return {void}
     */
    public reset(): void {
        for (let field in this._originalData) {
            this._data[field] = "";
        }

        this._errors.clear();
    }

    /**
     * Submit the form.
     *
     * @param {CallableFunction} func
     * @return {Promise<void|{data:FormData}|{data:Errors}>}
     */
    public async submit(
        func: CallableFunction
    ): Promise<void | FormData | Errors> {
        try {
            const response: FormData = await func(this.data);
            if (!response) {
                return;
            }

            this.onSuccess(response);
            return Promise.resolve(response);
        } catch (error) {
            if (!error) {
                return;
            }
            if (error.data) {
                error.errors = error.data.errors;
            }

            this.onFail(error.errors);
            return Promise.reject(error.errors);
        }
    }

    /**
     * Handle a successful form submission.
     *
     * @param {FormData} data
     * @return {void}
     */
    public onSuccess(data?: FormData): void {
        this.reset();
    }

    /**
     * Handle a failed form submission.
     *
     * @param {Errors} errors
     * @return {void}
     */
    public onFail(errors?: Errors): void {
        if (!errors) {
            return;
        }
        this._errors.record(errors);
    }
}
