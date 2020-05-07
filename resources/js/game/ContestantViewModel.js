export class ContestantViewModel {
    constructor(obj) {
        this.id = obj.id;   
        this.name = obj.name;
        this.score = obj.score;
        this.sick = obj.sick;
    }
    
    static build(obj) {
        return new ContestantViewModel(obj);
    }
}