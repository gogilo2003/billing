<template>
    <!-- Modal -->
    <div class="modal fade" id="clientViewModal" tabindex="-1" role="dialog" aria-labelledby="clientViewModal"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="close btn btn-link" @click="close" aria-label="Close">
                        <i class="tim-icons icon-simple-remove"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="modal-title">Client Details</h3>
                    <div>Name: {{ client.name }}</div>
                    <div>Email: {{ client.Email }}</div>
                    <h4 class="modal-title mt-3">ACCOUNTS</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>NAME</td>
                                <td>CREDIT</td>
                                <td>DEBIT</td>
                                <td>BALANCE</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="account in client.accounts" :key="account.id">
                                <td>{{ account.id }}</td>
                                <td>{{ account.name }}</td>
                                <td>{{ account.credit }}</td>
                                <td>{{ account.debit }}</td>
                                <td>{{ account.balance }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close">Close</button>
                    <a :href="`/clients/download/${client.id}`" class="btn btn-primary">Download</a>
                </div>
            </div>
        </div>
    </div>

</template>
<script>

export default {
    props: {
        client: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            title: `View Client Details`
        }
    }
    , methods: {
        close() {
            $('#clientViewModal').modal('hide')
        },
    }
}
</script>
