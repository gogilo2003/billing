<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6 text-uppercase">
                        <h3 class="card-title">Invoices</h3>
                    </div>
                    <div
                        class="col-md-6 d-flex"
                        style="
                            justify-content: flex-end;
                            align-items: flex-start;
                        "
                    >
                        <!-- Button trigger modal -->
                        <label
                            class="btn btn-success btn-sm"
                            @click="newInvoice"
                        >
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
                                <th>Client</th>
                                <th>Name</th>
                                <th>DATE</th>
                                <th>Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(invoice, index) in invoices.data"
                                :key="invoice.id"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ invoice.client.name }}</td>
                                <td>{{ invoice.name }}</td>
                                <td>{{ invoice.created_at }}</td>
                                <td class="text-right">{{ invoice.amount }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button
                                            class="btn btn-link"
                                            @click="editInvoice(invoice)"
                                        >
                                            <span
                                                class="tim-icons icon-pencil"
                                            ></span>
                                        </button>
                                        <button
                                            class="btn btn-link"
                                            @click="viewInvoice(invoice)"
                                        >
                                            <span
                                                class="tim-icons icon-paper"
                                            ></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <div class="btn-group">
                                        <button
                                            @click="
                                                nextPage(invoices.links.first)
                                            "
                                            style="cursor: pointer"
                                            :disabled="
                                                invoices.links.first == null ||
                                                invoices.meta.current_page == 1
                                            "
                                            class="
                                                btn
                                                btn-sm
                                                btn-primary
                                                btn-simple
                                            "
                                        >
                                            <span
                                                class="
                                                    tim-icons
                                                    icon-double-left
                                                "
                                            ></span>
                                        </button>
                                        <button
                                            @click="
                                                nextPage(invoices.links.prev)
                                            "
                                            style="cursor: pointer"
                                            :disabled="
                                                invoices.links.prev == null
                                            "
                                            class="
                                                btn
                                                btn-sm
                                                btn-primary
                                                btn-simple
                                            "
                                        >
                                            <span
                                                class="
                                                    tim-icons
                                                    icon-minimal-left
                                                "
                                            ></span>
                                        </button>
                                        <button
                                            @click="
                                                nextPage(invoices.links.next)
                                            "
                                            style="cursor: pointer"
                                            :disabled="
                                                invoices.links.next == null
                                            "
                                            class="
                                                btn
                                                btn-sm
                                                btn-primary
                                                btn-simple
                                            "
                                        >
                                            <span
                                                class="
                                                    tim-icons
                                                    icon-minimal-right
                                                "
                                            ></span>
                                        </button>
                                        <button
                                            @click="
                                                nextPage(invoices.links.last)
                                            "
                                            style="cursor: pointer"
                                            :disabled="
                                                invoices.links.last == null ||
                                                invoices.meta.current_page ==
                                                    invoices.meta.last_page
                                            "
                                            class="
                                                btn
                                                btn-sm
                                                btn-primary
                                                btn-simple
                                            "
                                        >
                                            <span
                                                class="
                                                    tim-icons
                                                    icon-double-right
                                                "
                                            ></span>
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
        <invoice-detail :invoice="selectedInvoice" :edit.sync="edit" />
        <invoice-view :invoice="selectedInvoice" />
    </div>
</template>
<script>
import mixins from "../../mixins/mixins";
import InvoiceDetail from "./Detail.vue";
import InvoiceView from "./View.vue";
export default {
    data() {
        return {
            invoices: {
                data: [],
                links: {},
            },
            clients: [],
            states: [],
            title: "New Invoice",
            edit: false,
            view: false,
            selectedInvoice: {
                id: null,
                name: null,
                created_at: null,
                amount: null,
                client: {
                    id: null,
                    name: "",
                    phone: "",
                    email: "",
                    postal_address: "",
                },
                items: [],
            },
        };
    },
    mixins: [mixins],
    components: {
        InvoiceDetail,
        InvoiceView,
    },
    methods: {
        newInvoice() {
            this.selectedInvoice = {
                invoice: null,
                registered_on: null,
                expires_on: null,
                remarks: null,
                status: null,
                client_id: null,
            };
            this.edit = false;
            $("#invoicesModalDialog").modal("show");
        },
        editInvoice(invoice) {
            this.edit = true;
            this.selectedInvoice = invoice;
            $("#invoicesModalDialog").modal("show");
        },
        viewInvoice(invoice) {
            this.selectedInvoice = invoice;
            $("#invoiceViewModalDialog").modal("show");
        },
        nextPage(url) {
            axios.get(url).then((response) => {
                this.invoices = response.data;
            });
        },
        getInvoices() {
            axios.get("/api/invoices").then((response) => {
                this.invoices = response.data;
            });
        },
    },
    mounted() {
        this.getInvoices();
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
