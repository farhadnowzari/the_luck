<template>
    <div>
        <div class="border-bottom py-1 px-3 text-muted d-flex align-items-center">
            <button @click="$emit('main-menu')" class="btn btn-link p-0" type="button">Main Menu</button>
            <span class="mx-2">|</span>
            <span title="Contestants"><i class="fa fa-users"></i> {{totalContestants}}</span>
            <span class="mx-2">|</span>
            <span>Round <strong>{{model.finishedRounds + 1}}/{{model.totalRounds}}</strong></span>
            <span class="mx-2">|</span>
            <span title="Genre" v-if="activeRound"><i class="fa fa-music"></i> {{activeRound.genreText}}</span>
        </div>
        <round 
            @evaluate="processEvaludatedRound" 
            :round="activeRound" 
            :key="activeRound.id"
            ref="roundComponent" 
            v-if="activeRound"></round>
    </div>
</template>

<script>
import {ContestViewModel} from './ContestViewModel';
import Round from './Round';
export default {
    components: {
        Round,
    },
    computed: {
        activeRound() {
            if(this.availableRounds && this.availableRounds.length > 0) {
                return this.availableRounds[0];
            }
            return null;
        },
        totalContestants() {
            return this.model.contestants.length;
        },
        availableRounds() {
            const rounds = this.model.rounds;
            return rounds.filter(r => {
                return !this.finishedRounds.find(fr => fr === r.id);
            });
        }
    },
    data() {
        return {
            finishedRounds: [],
            model: ContestViewModel.build(this.contest),
        }
    },
    methods: {
        async requestNextRound() {
            await this.$refs.roundComponent.evaluateRound();
        },
        processEvaludatedRound(contest) {
            this.$emit('evaluate', contest);
            if(contest.finishedRounds === contest.totalRounds) {
                this.$emit('finish');
            }
        }
    },
    mounted() {
        this.model.rounds.forEach((round) => {
            if(round.finished()) {
                this.finishedRounds.push(round.id);
            }
        })
    },
    name: 'contest',
    props: {
        contest: {
            type: Object,
            required: true
        }
    },
}
</script>