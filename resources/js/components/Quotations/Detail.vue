<template>
    <div class="modal fade" id="quotationsModalDialog" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 800px; min-width: 800px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="clientInput">Client</label>
                            <select class="form-control" name="clientInput" id="clientInput"
                                v-model="selectedQuotation.client.id" :value="selectedQuotation.client.id">
                                <option v-for="client in clients" :key="client.id" :value="client.id"
                                    v-html="client.name"></option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="validityInput">Quotation Validity</label>
                            <input type="text" class="form-control" name="validityInput" id="validityInput"
                                aria-describedby="helpId" placeholder="Quotation validity"
                                v-model="selectedQuotation.validity" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="descriptionInput">Quotation Description</label>
                            <input type="text" class="form-control" name="descriptionInput" id="descriptionInput"
                                aria-describedby="helpId" placeholder="Quotation description"
                                v-model="selectedQuotation.description" />
                        </div>
                        <div class="col-md-12">
                            <h4>Quotation Items</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 55%" class="text-left">
                                            Particulars
                                        </th>
                                        <th style="width: 15%" class="text-left">
                                            Price
                                        </th>
                                        <th style="width: 15%" class="text-left">
                                            Quantity
                                        </th>
                                        <th style="width: 15%" class="text-left">
                                            Amount
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(
                                            item, index
                                        ) in selectedQuotation.items" :key="index">
                                        <td>{{ item.particulars }}</td>
                                        <td>{{ item.price }}</td>
                                        <td>{{ item.quantity }}</td>
                                        <td>{{ item.amount }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="
                                                        btn btn-link
                                                        text-success
                                                    " @click="editItem(item)">
                                                    <span class="
                                                            tim-icons
                                                            icon-pencil
                                                        "></span>
                                                </button>
                                                <button class="
                                                        btn btn-link
                                                        text-danger
                                                    " @click="removeItem(index)">
                                                    <span class="
                                                            tim-icons
                                                            icon-simple-remove
                                                        "></span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="particulars" id="particulars"
                                                aria-describedby="particularsHelpId" placeholder="particulars"
                                                v-model="item.particulars" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="price" id="price"
                                                aria-describedby="priceHelpId" placeholder="price" @change="setAmount"
                                                v-model="item.price" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="quantity" id="quantity"
                                                aria-describedby="quantityHelpId" placeholder="quantity"
                                                @change="setAmount" v-model="item.quantity" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="amount" id="amount"
                                                aria-describedby="amountHelpId" placeholder="amount"
                                                v-model="item.amount" readonly />
                                        </td>
                                        <td>
                                            <button @click="addItem" class="btn btn-link text-info" :disabled="!filled">
                                                <span class="
                                                        tim-icons
                                                        icon-simple-add
                                                    "></span>
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary btn-round" @click="save()">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        quotation: {
            type: Object,
            required: true,
            default: {}
        },
        edit: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            selectedQuotation: {
                id: null,
                description: null,
                validity: 0,
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
            title: "Manage Quotation",
            clients: [],
            states: [],
            accounts: [],
            item: {
                id: null,
                particulars: null,
                price: null,
                quantity: null,
                amount: null,
            },
        };
    },
    computed: {
        filled() {
            return (
                this.item.particulars && this.item.price && this.item.quantity
            );
        },
    },
    methods: {
        setAmount() {
            this.item.amount =
                parseFloat(this.item.price) * parseInt(this.item.quantity);

            this.item.amount = isNaN(this.item.amount) ? 0 : this.item.amount;
        },
        async getClients() {
            await axios.get(`/api/clients/list?api_token=${window.API_TOKEN}`).then((response) => {
                this.clients = response.data.data
            });
        },
        addItem() {
            this.selectedQuotation.items.unshift(this.item);
            this.item = {
                id: null,
                particulars: null,
                price: null,
                quantity: null,
                amount: null,
            };
        },
        editItem(item) {
            this.item = item;
        },
        removeItem(index) {
            this.selectedQuotation.items.splice(index, 1);
        },
        save() {
            if (this.edit) {
                axios
                    .patch("/api/quotations", this.selectedQuotation)
                    .then((response) => {
                        $.notify(
                            {
                                message: response.data.message,
                            },
                            {
                                type: "success",
                            }
                        );
                        this.selectedQuotation = {
                            quotation: null,
                            name: null,
                            account_id: null,
                            items: [],
                        };
                        $("#quotationsModalDialog").modal("hide");
                    })
                    .catch((error) => {
                        if (error.response.status == 415) {
                            let details = `<ol>`;
                            for (const [key, value] of Object.entries(
                                error.response.data.details
                            )) {
                                details += `<li class="text-white">${value}</li>`;
                            }
                            details += `</ol>`;
                            $.notify(
                                {
                                    title: `<h4 class="text-white text-uppercase">${error.response.data.message}</h4>`,
                                    message: details,
                                },
                                {
                                    type: "danger",
                                }
                            );
                        } else {
                            console.log(error.response.data.message);
                        }
                    });
            } else {
                axios
                    .post("/api/quotations", this.selectedQuotation)
                    .then((response) => {
                        $.notify(
                            {
                                message: response.data.message,
                            },
                            {
                                type: "success",
                            }
                        );
                        this.selectedQuotation = {
                            quotation: null,
                            name: null,
                            account_id: null,
                            items: [],
                        };
                        $("#quotationsModalDialog").modal("hide");
                        this.quotations.unshift(response.data.quotation);
                    })
                    .catch((error) => {
                        if (error.response.status == 415) {
                            let details = `<ol>`;
                            for (const [key, value] of Object.entries(
                                error.response.data.details
                            )) {
                                details += `<li class="text-white">${value}</li>`;
                            }
                            details += `</ol>`;
                            $.notify(
                                {
                                    title: `<h4 class="text-white text-uppercase">${error.response.data.message}</h4>`,
                                    message: details,
                                },
                                {
                                    type: "danger",
                                    allow_dismiss: false,
                                }
                            );
                        } else {
                            console.log(error.response.data.message);
                        }
                    });
            }
        },
    },
    async mounted() {
        await this.getClients();
    },
    watch: {
        quotation(val) {
            this.selectedQuotation = val;
        },
    },
    components: {},
};
</script>
