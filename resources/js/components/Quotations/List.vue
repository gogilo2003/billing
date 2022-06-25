<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6 text-uppercase">
                        <h3 class="card-title">Quotations</h3>
                    </div>
                    <div class="col-md-6 d-flex" style="
                            justify-content: flex-end;
                            align-items: flex-start;
                        ">
                        <input type="text" class="form-control" placeholder="Search" v-model="search"
                            @keypress.13="getQuotations" />
                        <!-- Button trigger modal -->
                        <label class="btn btn-success btn-sm" @click="newQuotation">
                            NEW
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Client Name</th>
                                <th>Prepared By</th>
                                <th>Date</th>
                                <th class="text-right">Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(quotation, index) in quotations.data" :key="quotation.id">
                                <td>{{ index + 1 }}</td>
                                <td>
                                    {{
                                            quotation.client
                                                ? quotation.client.name
                                                : ""
                                    }}
                                </td>
                                <td>{{ quotation.user ? quotation.user.name : "" }}</td>
                                <td>{{ quotation.created_at }}</td>
                                <td class="text-right">{{ new
                                        Intl.NumberFormat("en-US", {
                                            style: "currency", currency: "KES"
                                        }).format(quotation.amount)
                                }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-link" @click="editQuotation(quotation)">
                                            <span class="tim-icons icon-pencil"></span>
                                        </button>
                                        <button class="btn btn-link" @click="viewQuotation(quotation)">
                                            <span class="tim-icons icon-paper"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <div class="btn-group">
                                        <button @click="
                                            nextPage(quotations.links.first)
                                        " style="cursor: pointer" :disabled="
    quotations.links.first == null ||
    quotations.meta.current_page == 1
" class="
                                                btn
                                                btn-sm
                                                btn-primary
                                                btn-simple
                                            ">
                                            <span class="
                                                    tim-icons
                                                    icon-double-left
                                                "></span>
                                        </button>
                                        <button @click="
                                            nextPage(quotations.links.prev)
                                        " style="cursor: pointer" :disabled="
    quotations.links.prev == null
" class="
                                                btn
                                                btn-sm
                                                btn-primary
                                                btn-simple
                                            ">
                                            <span class="
                                                    tim-icons
                                                    icon-minimal-left
                                                "></span>
                                        </button>
                                        <button @click="
                                            nextPage(quotations.links.next)
                                        " style="cursor: pointer" :disabled="
    quotations.links.next == null
" class="
                                                btn
                                                btn-sm
                                                btn-primary
                                                btn-simple
                                            ">
                                            <span class="
                                                    tim-icons
                                                    icon-minimal-right
                                                "></span>
                                        </button>
                                        <button @click="
                                            nextPage(quotations.links.last)
                                        " style="cursor: pointer" :disabled="
    quotations.links.last == null ||
    quotations.meta.current_page ==
    quotations.meta.last_page
" class="
                                                btn
                                                btn-sm
                                                btn-primary
                                                btn-simple
                                            ">
                                            <span class="
                                                    tim-icons
                                                    icon-double-right
                                                "></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modals -->
        <quotation-detail :quotation="selectedQuotation" :edit.sync="edit" />
        <quotation-view :quotation="selectedQuotation" />
    </div>
</template>
<script>
import mixins from "../../mixins/mixins";
import QuotationDetail from "./Detail.vue";
import QuotationView from "./View.vue";
export default {
    data() {
        return {
            search: "",
            quotations: {
                data: [],
                links: {},
            },
            clients: [],
            states: [],
            title: "New Quotation",
            edit: false,
            view: false,
            selectedQuotation: {
                id: null,
                description: "Some description should go here",
                validity: 30,
                amount: null,
                client: {
                    id: null,
                    name: null,
                    phone: null,
                    email: null,
                    postal_address: null,
                    address: null,
                    accounts: []
                },
                user: {
                    id: null,
                    name: null,
                    phone: null,
                    email: null,
                    box_no: null,
                    post_code: null,
                    town: null,
                    address: null,
                    notification: null,
                    balance: null,
                    latest_cr_date: null,
                    latest_dr_date: null,
                    latest_transaction_date: null,
                    created_at: null
                },
                items: [],
                created_at: null,
            },
        };
    },
    mixins: [mixins],
    components: {
        QuotationDetail,
        QuotationView,
    },
    methods: {
        newQuotation() {
            this.selectedQuotation = {
                id: null,
                description: null,
                validity: null,
                amount: null,
                client: {
                    id: null,
                    name: null,
                    phone: null,
                    email: null,
                    postal_address: null,
                    address: null,
                    accounts: []
                },
                user: {
                    id: null,
                    name: null,
                    phone: null,
                    email: null,
                    box_no: null,
                    post_code: null,
                    town: null,
                    address: null,
                    notification: null,
                    balance: null,
                    latest_cr_date: null,
                    latest_dr_date: null,
                    latest_transaction_date: null,
                    created_at: null
                },
                items: [],
                created_at: null,
            };
            this.edit = false;
            $("#quotationsModalDialog").modal("show");
        },
        editQuotation(quotation) {
            this.edit = true;
            this.selectedQuotation = quotation;
            $("#quotationsModalDialog").modal("show");
        },
        viewQuotation(quotation) {
            this.selectedQuotation = quotation;
            $("#quotationViewModalDialog").modal("show");
        },
        nextPage(url) {
            if (this.search) {
                url += `?api_token=${window.API_TOKEN}&search=${this.search}`;
            }
            axios.get(url).then((response) => {
                this.quotations = response.data;
            });
        },
        getQuotations() {
            let url = `/api/quotations?api_token=${window.API_TOKEN}` + (this.search
                ? "&search=" + this.search
                : "");
            axios.get(url).then((response) => {
                this.quotations = response.data;
            });
        },
    },
    mounted() {
        this.getQuotations();
    },
};
</script>
<style>
.modal-open .modal.show {
    display: flex !important;
}

.modal.show .modal-dialog {
    -webkit-transform: translate(0, 0);
    transform: translate(0, 0);
    align-self: center;
    width: 500px;
}

.alert span ol {
    padding-left: 0;
    margin-left: 1rem;
}
</style>
