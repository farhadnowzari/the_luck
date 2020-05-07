export class JudgeViewModel {
    constructor(obj) {
        this.id = obj.id;
        this.name = obj.name;
    }

    static build(obj) {
        return new JudgeViewModel(obj);
    }
}