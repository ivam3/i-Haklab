declare class Tagin {
    private classElement;
    private classWrapper;
    private classTag;
    private classRemove;
    private classInput;
    private classInputHidden;
    private target;
    private wrapper;
    private input;
    private separator;
    private placeholder;
    private duplicate;
    private transform;
    private enter;
    constructor(inputElement: HTMLInputElement, options?: Options);
    private createWrapper;
    private createTag;
    private getValue;
    private getValues;
    getTags(): string[];
    getTag(): string;
    private updateValue;
    private autowidth;
    private addEventListener;
    private appendTag;
    private alertExist;
    private updateTag;
    addTag(tag: string | string[]): void;
}
export default Tagin;
interface Options {
    separator?: string;
    placeholder?: string;
    duplicate?: boolean;
    transform?: string;
    enter?: boolean;
}
