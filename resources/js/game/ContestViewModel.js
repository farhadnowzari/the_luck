import { RoundViewModel } from "./RoundViewModel";
import { ContestantViewModel } from "./ContestantViewModel";

export class ContestViewModel {
    constructor(obj) {
        this.id = obj.id;
        this.totalRounds = obj.totalRounds;
        this.finishedRounds = obj.finishedRounds;
        this.createdAt = obj.createdAt;

        this.winnerName = obj.winnerName;
        this.highestScore = obj.highestScore;

        this.rounds = obj.rounds.map((round) => {
            return RoundViewModel.build(round);
        });
        this.contestants = obj.contestants.map((contestant) => {
            return ContestantViewModel.build(contestant);
        });
    }

    static build(obj) {
        if(!obj) return null;
        return new ContestViewModel(obj);
    }
}