<template>
    <div class="d-flex align-items-center h-100">
        <div class="container px-0 rounded shadow-sm bg-white mw-md">
            <div class="w-100 border-bottom d-flex align-items-center py-2 px-3">
                <h5 class="mb-0 mr-auto">Contests</h5>
                <button @click="createContest()" class="btn btn-primary" type="button" v-if="contest === null">New Contest</button>
                <button @click="nextRound()" class="btn btn-primary" type="button" v-else>Next Round</button>
            </div>
            <div v-if="contest === null">
                <div class="d-flex align-items-center justify-content-center flex-column w-100 my-5" v-if="noOldContests">
                    <img class="img-fluid mw-xs" src="images/not_found_cute.png" alt="not_found">
                    <p>There is no contest available for you, please start a new contest by pressing the button below</p>
                    <button @click="createContest()" class="btn btn-primary" type="button">New Contest!</button>
                </div>
                <div v-else>
                    <div class="row mx-0 border-bottom bg-light py-2">
                        <div class="col-3">Winner</div>
                        <div class="col-3">High score</div>
                        <div class="col">Created At</div>
                    </div>
                    <div :key="index" class="row border-bottom mx-0 py-2" v-for="(contest, index) in oldContests">
                        <div class="col-3"></div>
                        <div class="col-3"></div>
                        <div class="col">{{contest.createdAt}}</div>
                    </div>
                </div>
            </div>
            <contest :contest="contest" ref="contestComponent" v-else></contest>
        </div>
        <loader v-if="loading" text="Please wait"></loader>
    </div>
</template>
<script>
import Contest from './Contest';
import loader from '../components/loader';
const SESSION_ID = window.theLuck.get('sessionId');
export default {
    components: {
        Contest,
        loader
    },
    computed: {
        noOldContests() {
            return this.oldContests.length === 0;
        }
    },
    data() {
        return {
            loading: false,
            oldContests: [],
            contest: null
        }
    },
    methods: {
        createContest() {
            this.loading = true;
            axios({
                url: route('api.contests.create'),
                method: 'post'
            })
            .then(response => {
                this.loading = false;
                this.retrieveOngoingContest();
            })
            .catch(e => {
                console.error(e);
                this.loading = false;
            })

        },
        retrieveOngoingContest() {
            this.loading = true;
            axios({
                url: route('api.contests.get_paused_contest'),
                method: 'get',
            })
            .then(response => {
                this.contest = response.data === {} || !response.data ? null : response.data;
                this.loading = false;
            })
            .catch(e => {
                console.error(e);
                this.loading = false;
            });
        },
        async loadMenu() {
            this.loading = true;
            try {
                let response = await axios({
                    method: 'get',
                    url: route('api.contests.list'),
                });
                this.oldContests = response.data;
                response = await axios({
                    method: 'get',
                    url: route('api.contests.get_paused_contest')
                });
                this.contest = response.data === {} || !response.data ? null : response.data;
                this.loading = false;
            } catch(e) {
                cosole.error(e);
                this.loading = false;
            }         
        },
        async nextRound() {
            await this.$refs.contestComponent.requestNextRound();
        }
    },
    async mounted() {
        await this.loadMenu();  
    },
    name: 'main-menu',
}
</script>