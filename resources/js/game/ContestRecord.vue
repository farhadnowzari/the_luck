<template>
    <div>
        <div class="row border-bottom py-2 mx-0">
            <div class="col-2">{{ contest.winnerName }}</div>
            <div class="col-2">{{ contest.highestScore }}</div>
            <div class="col">{{ contest.createdAt }}</div>
            <div class="col">
                <button data-toggle="modal" :data-target="`#contest-details-modal-${contest.id}`" class="btn btn-link p-0" type="button">Details</button>
            </div>
        </div>
        <div :id="`contest-details-modal-${contest.id}`" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div :key="index" :class="{'border-bottom': index < contest.contestants.length - 1}" class="row mx-0 py-2" v-for="(contestant, index) in contest.contestants">
                            <div class="col-6">{{contestant.name}}</div>
                            <div class="col-6">{{contestant.score}}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'contest-record',
    props: {
        contest: {
            type: Object,
            required: true
        }
    }
}
</script>