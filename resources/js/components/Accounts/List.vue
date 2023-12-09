<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="card-title" style="width:80%; float:left">Clients</div>
                <button class="btn btn-primary btn-sm btn-link" @click="newButton" style="float:right">
                    <i class="tim-icons icon-simple-add"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <data-table title="News" :rows="clients" :columns="columns" style="width:100%">
                        <th slot="thead-tr">
                            Actions
                        </th>
                        <template slot="tbody-tr" scope="props">
                            <td class="text-center actions" style="overflow: visible">
                                <div class="tasks-wraper">
                                    <button class="btn btn-link btn-primary" type="button"
                                        @click="showTasks(`taskButtons-${props.row.id}`)">
                                        <font-awesome-icon icon="fas fa-ellipsis-h" />
                                    </button>
                                    <div class="task-buttons" :id="`taskButtons-${props.row.id}`">
                                        <button type="button" @click="(e) => editButton(props.row, e)" title="Edit"
                                            class="btn btn-sm btn-link">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                        <button type="button" @click="(e) => viewButton(props.row, e)" title="View"
                                            class="btn btn-sm btn-link">
                                            <i class="tim-icons icon-single-copy-04"></i>
                                        </button>
                                        <a type="button" target="_BLANK" :href="`/clients/download/${props.row.id}`"
                                            title="Download" class="btn btn-sm btn-link">
                                            <i class="tim-icons icon-cloud-download-93"></i>
                                        </a>
                                        <button type="button" @click="(e) => accountsButton(props.row.id, e)"
                                            title="Accounts" class="btn btn-sm btn-link">
                                            <i class="tim-icons icon-bank"></i>
                                        </button>
                                        <button type="button" @click="(e) => quotationsButton(props.row.id, e)"
                                            title="Quotations" class="btn btn-sm btn-link">
                                            <i class="tim-icons icon-notes"></i>
                                        </button>
                                        <button type="button" @click="(e) => invoicesButton(props.row.id, e)"
                                            title="Invoices" class="btn btn-sm btn-link">
                                            <i class="tim-icons icon-paper"></i>
                                        </button>
                                        <button type="button" @click="(e) => deleteButton(props.row.id, e)" title="Delete"
                                            class="btn btn-sm btn-danger btn-link">
                                            <i class="tim-icons icon-trash-simple"></i>
                                        </button>
                                        <button type="button" @click="(e) => hideTasks(e)" title="Close Tasks"
                                            class="btn btn-sm btn-secondary btn-link">
                                            <i class="tim-icons icon-simple-remove"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </template>
                    </data-table>
                </div>
            </div>
        </div>
        <client-detail :client="client" :edit.sync="edit" @updated="clientUpdated" @stored="clientStored" />
        <client-view :client="client" />
        <client-accounts :accounts="accounts" :show="showAccounts" />
    </div>
</template>
<script>
import ClientDetail from './Detail.vue'
import ClientView from './View.vue'
import AccountTransactions from './Transactions.vue'
import DataTable from "vue-materialize-datatable"

export default {
    data: () => {
        return {
            clients: [],
            columns: [
                { label: 'ID', field: 'id' },
                { label: 'Name', field: 'name' },
                { label: 'Phone', field: 'phone' },
                { label: 'Email', field: 'email' },
                { label: 'Balance', field: 'balance' },
            ],
            page: [],
            pageIndex: 0,
            edit: false,
            client: {},
            showAccounts: false,
            accounts: []
        }
    },
    methods: {
        async getAccounts() {

            // $('#clientsDataTable').DataTable({
            //     ajax: {
            //         url: `/api/clients?api_token=${window.API_TOKEN}`,
            //         dataSrc: ''
            //     },
            //     columns: [
            //         { data: 'id' },
            //         { data: 'name' },
            //         { data: 'phone' }
            //     ]
            // });
            return await axios.get(`/api/clients?api_token=${window.API_TOKEN}`).then(response => {
                this.clients = response.data.data
            })
        },
        nextPage(page) {
            this.page = this.clients[page]
        },
        newButton() {
            this.edit = false
            this.client = {}
            $('#clientDetailModal').modal('show')
        },
        editButton(client) {
            this.edit = true
            this.client = client
            $('#clientDetailModal').modal('show')
        },
        viewButton(client) {
            this.client = client
            $('#clientViewModal').modal('show')
        },
        downloadButton(id) {
            alert(`Download ${id}`)
        },
        accountsButton(id) {
            this.showAccounts = true
        },
        quotationsButton(id) {
            alert(`Quotations ${id}`)
        },
        invoicesButton(id) {
            alert(`Invoices ${id}`)
        },
        deleteButton(id) {
            alert(`Delete ${id}`)
        },
        clientUpdated() {
            this.getAccounts()
        },
        clientStored() {
            this.getAccounts()
        },
        showTasks(id) {
            document.querySelectorAll('.task-buttons').forEach(item => { item.classList.remove('show') })
            document.getElementById(id).classList.add('show')
        },
        hideTasks() {
            document.querySelectorAll('.task-buttons').forEach(item => { item.classList.remove('show') })
        },
    },
    components: {
        ClientDetail,
        ClientView,
        AccountTransactions,
        DataTable,
    },
    mounted() {
        this.getAccounts()
    }
}
</script>
<style lang="scss" scoped>
td.actions {

    .tasks-wraper {
        position: relative;
        overflow: visible;

        .task-buttons {
            position: absolute;
            right: 48px;
            top: 0px;
            background-color: rgba($color: #fff, $alpha: 0.9);
            padding: 0.175rem 0;
            border-top-left-radius: 2rem;
            border-bottom-left-radius: 2rem;
            box-shadow: 10px 10px 20px rgba($color: #000000, $alpha: 0.35);
            display: flex;
            width: 0;
            overflow: hidden;
            transition: all 300ms ease-in-out;
        }

        .task-buttons.show {
            display: flex;
            flex-direction: row;
            width: 388px;
        }
    }
}
</style>
