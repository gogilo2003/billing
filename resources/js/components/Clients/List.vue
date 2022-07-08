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
                <table class="table table-hover table-striped">
                    <thead>
                        <tr class="d-sm-table-row d-none">
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Balance</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="d-sm-table-row d-flex flex-column" v-for="(client, index) in page" :key="client.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ client.name.toUpperCase() }}</td>
                            <td>{{ client.phone }}</td>
                            <td>{{ new Intl.NumberFormat("en-US", {
                                    style: "currency", currency: "KES"
                                }).format(client.balance)
                            }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" @click="editButton(client)" title="Edit"
                                        class="btn btn-sm btn-link">
                                        <i class="tim-icons icon-pencil"></i>
                                    </button>
                                    <button type="button" @click="viewButton(client.id)" title="View"
                                        class="btn btn-sm btn-link">
                                        <i class="tim-icons icon-single-copy-04"></i>
                                    </button>
                                    <button type="button" @click="downloadButton(client.id)" title="Download"
                                        class="btn btn-sm btn-link">
                                        <i class="tim-icons icon-cloud-download-93"></i>
                                    </button>
                                    <button type="button" @click="accountsButton(client.id)" title="Accounts"
                                        class="btn btn-sm btn-link">
                                        <i class="tim-icons icon-bank"></i>
                                    </button>
                                    <button type="button" @click="quotationsButton(client.id)" title="Quotations"
                                        class="btn btn-sm btn-link">
                                        <i class="tim-icons icon-notes"></i>
                                    </button>
                                    <button type="button" @click="invoicesButton(client.id)" title="Invoices"
                                        class="btn btn-sm btn-link">
                                        <i class="tim-icons icon-paper"></i>
                                    </button>
                                    <button type="button" @click="deleteButton(client.id)" title="Delete"
                                        class="btn btn-sm btn-danger btn-link">
                                        <i class="tim-icons icon-trash-simple"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-primary btn-simple"
                                        @click="nextPage(pageIndex > 0 ? --pageIndex : 0)">
                                        <i class="tim-icons icon-double-left"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary btn-simple"
                                        @click="nextPage(pageIndex > 0 ? --pageIndex : 0)">
                                        <i class="tim-icons icon-minimal-left"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary btn-simple"
                                        @click="nextPage(pageIndex < clients.length ? ++pageIndex : clients.length)">
                                        <i class="tim-icons icon-minimal-right"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary btn-simple"
                                        @click="nextPage(pageIndex < clients.length ? ++pageIndex : clients.length)">
                                        <i class="tim-icons icon-double-right"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <client-detail :client="client" :edit.sync="edit" @updated="clientUpdated" @stored="clientStored" />
    </div>
</template>
<script>
import ClientDetail from './Detail.vue'
export default {
    data: () => {
        return {
            clients: [],
            page: [],
            pageIndex: 0,
            edit: false,
            client: {}
        }
    },
    methods: {
        async getClients() {
            return await axios.get(`/api/clients?api_token=${window.API_TOKEN}`).then(response => {
                this.clients = response.data
                this.nextPage(0)
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
        viewButton(id) {
            alert(`View ${id}`)
        },
        downloadButton(id) {
            alert(`Download ${id}`)
        },
        accountsButton(id) {
            alert(`Accounts ${id}`)
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
            this.getClients()
        },
        clientStored() {
            this.getClients()
        },
    },
    components: {
        ClientDetail
    },
    mounted() {
        this.getClients()
    }
}
</script>
