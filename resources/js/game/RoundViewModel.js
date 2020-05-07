import {RoundState} from './RoundState';
import { JudgeViewModel } from "./JudgeViewModel";
import { ContestantViewModel } from "./ContestantViewModel";

export class RoundViewModel {
    constructor(obj) {
        this.id = obj.id;
        this.genreId = obj.genreId;
        this.genreText = obj.genreText;
        this.state = obj.state;
        this.judges = obj.judges.map((judge) => {
            return JudgeViewModel.build(judge);
        });
        this.contestants = obj.contestants.map((contestant) => {
            return ContestantViewModel.build(contestant);
        });
    }

    static build(obj) {
        return new RoundViewModel(obj);
    }

    finished() {
        return this.state === RoundState.FINISHED;
    }
}