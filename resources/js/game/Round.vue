<template>
    <div>
        <loader text="Please wait" v-if="loading"></loader>
        <div class="p-4">
            <div class="d-flex align-items-start justify-content-center pb-3">
                <div :key="index" class="mx-1 d-flex align-items-center justify-content-center flex-column" v-for="(judge, index) in model.judges">
                    <img class="img-fluid w-100" :src="judgeImage" alt="judge image" title="Judge" />
                    <strong>{{judge.name}}</strong>
                </div>
            </div>
            <div class="row mx-0 pt-3 border-top">
                <div :key="index" class="col-3 p-3 d-flex align-items-center justify-content-center flex-column" v-for="(contestant, index) in model.contestants">
                    <i class="fa fa-user fa-2x text-muted" title="Contestant"></i>
                    <strong class="d-flex align-items-center mt-1">
                        <span class="mr-1">{{contestant.name}}</span>
                        <i class="fa fa-frown text-warning" title="Sick" v-if="contestant.sick"></i>
                    </strong>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {RoundState} from './RoundState.js';
import {RoundViewModel} from './RoundViewModel';
import loader from '../components/loader';
export default {
    components: {
        loader,
    },
    computed: {
        judgeImage() {
            return 'images/judge.png';
        }
    },
    data() {
        return {
            loading: false,
            model: RoundViewModel.build(this.round)
        }
    },
    mounted() {
        this.startRound();
    },
    methods: {
        async evaluateRound() {
            this.loading = true;
            try {
                let response = await axios({
                    url: route('api.rounds.evaluate', {roundId: this.model.id}),
                    method: 'post'
                });
                this.loading = false;
                this.$emit('evaluate', response.data);
            } catch(e) {
                console.error(e);
                this.loading = false;
            }
        },
        startRound() {
            if(this.model.finished()) return;
            this.loading = true;
            axios({
                url: route('api.rounds.start', {roundId: this.round.id}),
                method: 'post'
            })
            .then(response => {
                this.model = RoundViewModel.build(response.data);
                this.loading = false;
            })
            .catch(e => {
                this.loading = false;
                console.error(e);
            })
        },
    },
    name: 'round',
    props: {
        round: {
            type: Object,
            required: true
        }
    }
}
</script>