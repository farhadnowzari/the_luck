<template>
    <div>
        <div class="container px-0 rounded shadow-sm bg-white mw-md">
            <div class="w-100 border-bottom d-flex align-items-center py-2 px-3">
                <h5 class="mb-0 mr-auto">Contests</h5>
                <button @click="createContest()" class="btn btn-primary" type="button" v-if="contest === null">New Contest</button>
                <button @click="nextRound()" class="btn btn-primary" type="button" v-if="contest !== null && !forceMainMenu">{{nextRoundButtonText}}</button>
                <button @click="forceMainMenu = false" class="btn btn-primary" type="button" v-if="forceMainMenu">Resume Contest</button>
            </div>
            <div v-if="contest === null || forceMainMenu">
                <div class="d-flex align-items-center justify-content-center flex-column w-100 my-5 py-3" v-if="noOldContests">
                    <img class="img-fluid mw-xs" src="images/not_found_cute.png" alt="not_found">
                    <p>There is no contest available for you, please start a new contest by pressing the button below</p>
                    <button @click="createContest()" class="btn btn-primary" type="button">New Contest!</button>
                </div>
                <div v-else>
                    <div class="row mx-0 border-bottom bg-light py-2">
                        <div class="col-2">Winner</div>
                        <div class="col-2">High score</div>
                        <div class="col">Created At</div>
                        <div class="col"></div>
                    </div>
                    <contest-record 
                        :contest="contest" 
                        :key="index" 
                        v-for="(contest, index) in oldContests"></contest-record>
                    <div class="d-block" v-if="winnerOfAllTimes && oldContests.length > 1">
                        <div class="py-2 px-3 bg-light border-bottom">
                            <i class="fa fa-user-crown"></i> Winner of all times
                        </div>
                        <div class="row mx-0 py-2" v-if="winnerOfAllTimes">
                            <div class="col-2">
                                {{winnerOfAllTimes.winnerName}}
                            </div>
                            <div class="col-2">
                                {{winnerOfAllTimes.score}}
                            </div>
                            <div class="col">
                                {{winnerOfAllTimes.createdAt}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <contest 
                @evaluate="processEvaluation" 
                @finish="finishContest"
                @main-menu="requestMainMenu()"
                :contest="contest" 
                :key="contestComponentKey"
                ref="contestComponent" 
                v-else></contest>
        </div>
        <div class="modal fade" id="last-contest-winner-modal" tabindex="-1" v-if="lastContest">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Winner</h5>
                        <button class="close" type="button" data-dismiss='modal'>
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="w-100 d-flex align-items-center justify-content-center flex-column">
                            <i class="fa fa-trophy fa-3x text-warning"></i>
                            <h5 class="mt-3">{{lastContest.winnerName}}</h5>
                            <strong>{{lastContest.highestScore}}</strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-outline-secondary" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <loader v-if="loading" text="Please wait"></loader>
    </div>
</template>
<script>
import Contest from './Contest';
import ContestRecord from './ContestRecord';
import loader from '../components/loader';
import { ContestViewModel } from './ContestViewModel';
const SESSION_ID = window.theLuck.get('sessionId');
export default {
    components: {
        Contest,
        ContestRecord,
        loader
    },
    computed: {
        noOldContests() {
            return this.oldContests.length === 0;
        },
        nextRoundButtonText() {
            if(this.contest) {
                const remainingRounds = (this.contest.totalRounds - this.contest.finishedRounds) - 1;
                return remainingRounds === 1 ? 'Got to Final!' : remainingRounds === 0 ? 'Finish contest' : 'Evaluate round';
            }
            return 'N/A';
        }
    },
    data() {
        return {
            loading: false,
            oldContests: [],
            contest: null,
            contestComponentKey: 1,
            forceMainMenu: false,
            winnerOfAllTimes: null,
            lastContest: null,
            lastContestWinnerModal: null
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
        async finishContest() {
            this.lastContest = ContestViewModel.build(this.contest);
            this.contest = null;
            this.oldContests = [];
            this.loadMenu();
        },
        initialWinnerModal() {
            if(this.lastContestWinnerModal) {
                this.lastContestWinnerModal.modal('show');
            } else {
                var $modal = $('#last-contest-winner-modal');
                if($modal && $modal.length > 0) {
                    this.lastContestWinnerModal = $modal;
                    this.lastContestWinnerModal.modal('show');
                }
            }
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
        requestMainMenu() {
            this.forceMainMenu = true;
        },
        loadMenu() {
            this.loading = true;
            axios({
                method: 'get',
                url: route('api.contests.list')
            })
            .then(response => {
                this.oldContests = response.data.contests;
                this.winnerOfAllTimes = response.data.winnerOfAllTimes
                axios({
                    method: 'get',
                    url: route('api.contests.get_paused_contest')
                })
                .then(response => {
                    this.contest = response.data.length === 0 || !response.data ? null : response.data;
                    this.contest = ContestViewModel.build(this.contest);
                    this.loading = false;
                    this.initialWinnerModal();
                })
                .catch(e => {
                    console.error(e);
                    this.loading = false;
                })
            })
            .catch(e => {
                console.error(e);
                this.loading = false;
            });  
        },
        async nextRound() {
            await this.$refs.contestComponent.requestNextRound();
        },
        processEvaluation(contest) {
            this.contest = ContestViewModel.build(contest);
            this.contestComponentKey += 1;
        }
    },
    mounted() {
        this.loadMenu();  
    },
    name: 'main-menu',
}
</script>