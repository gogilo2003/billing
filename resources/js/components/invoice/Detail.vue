<template>
    <div class="modal fade" id="invoicesModalDialog" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                            <label for="clientInput">Account</label>
                            <select class="form-control" name="clientInput" id="clientInput"
                                v-model="selectedInvoice.account_id" :value="selectedInvoice.account_id">
                                <optgroup v-for="client in clients" :key="client.id" :label="client.name">
                                    <option v-for="account in client.accounts" :key="account.id" :value="account.id">
                                        ({{ client.name }})- {{ account.name }}</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nameInput">REF<small>(LPO Number/LSO Number/PO Number)</small></label>
                            <input type="text" class="form-control" name="nameInput" id="nameInput"
                                aria-describedby="helpId" placeholder="LPO Number/LSO Number/PO Number"
                                v-model="selectedInvoice.ref" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="nameInput">Invoice Name</label>
                            <input type="text" class="form-control" name="nameInput" id="nameInput"
                                aria-describedby="helpId" placeholder="Invoice name" v-model="selectedInvoice.name" />
                        </div>
                        <div class="col-md-12">
                            <h4>Invoice Items</h4>
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
                                    ) in selectedInvoice.items" :key="index">
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
        invoice: {
            type: Object,
            default: {
                invoice: null,
                name: null,
                account_id: null,
                items: [
                    {
                        id: null,
                        particulars: null,
                        price: null,
                        quantity: null,
                        amount: null,
                    },
                ],
            },
            required: true,
        },
        edit: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            selectedInvoice: {
                invoice: null,
                name: null,
                account_id: null,
                ref: null,
                items: [],
            },
            title: "Manage Invoice",
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
        async getAccounts(id = null) {
            let url = id ? `/api/clients/${id}/accounts` : `/api/clients`
            await axios.get(`${url}?api_token=${window.API_TOKEN}`).then((response) => {
                this.clients = response.data.data.filter(
                    (item) => item.accounts.length
                );
            });
        },
        addItem() {
            this.selectedInvoice.items.unshift(this.item);
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
            this.selectedInvoice.items.splice(index, 1);
        },
        save() {
            if (this.edit) {
                axios
                    .patch("/api/invoices", this.selectedInvoice)
                    .then((response) => {
                        $.notify(
                            {
                                message: response.data.message,
                            },
                            {
                                type: "success",
                            }
                        );
                        this.selectedInvoice = {
                            invoice: null,
                            name: null,
                            account_id: null,
                            items: [],
                        };
                        $("#invoicesModalDialog").modal("hide");
                    })
                    .catch((error) => {
                        console.log(error)
                        if (error.status == 415) {
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
                            console.log(error);
                            // console.log(error.response.data.message);
                        }
                    });
            } else {
                axios
                    .post("/api/invoices", this.selectedInvoice)
                    .then((response) => {
                        $.notify(
                            {
                                message: response.data.message,
                            },
                            {
                                type: "success",
                            }
                        );
                        this.selectedInvoice = {
                            invoice: null,
                            name: null,
                            account_id: null,
                            items: [],
                        };
                        $("#invoicesModalDialog").modal("hide");
                        this.$emit('created', response.data.invoice);
                    })
                    .catch((error) => {
                        if (error.status == 415) {
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
                            console.log(error);
                        }
                    });
            }
        },
    },
    async mounted() {
        await this.getAccounts();
    },
    watch: {
        invoice(val) {
            this.selectedInvoice = val;
        },
    },
    components: {},
};
</script>
