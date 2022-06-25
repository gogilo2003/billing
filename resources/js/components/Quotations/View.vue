<template>
    <div class="modal fade" id="quotationViewModalDialog" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-lg" role="document" style="min-width: 800px; max-width: 800px">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-uppercase">{{ title }}</h3>
                </div>
                <div class="modal-body">
                    <div style="text-align: center; margin-bottom: 1.5rem; display:grid; grid-template-columns:1fr 1fr">
                        <div class="text-left">
                            <h5 class="text-uppercase text-info mb-0">Quotation Number</h5>
                            <div style="margin-bottom:-10px">#{{ padChars(quotation.id, 6, '0', 'left') }}</div>
                            <div class="barcode"><img :src="quotation.barcode" /></div>
                        </div>
                        <div class="text-right">
                            <h5 class="text-uppercase text-info mb-0 mt-3">
                                Date Issued:
                            </h5>
                            <p class="mb-0">{{ quotation.created_at }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <h5 class="text-uppercase text-info mb-1">
                                Quotation For:
                            </h5>
                            <p>
                                {{ quotation.client.name }},<br />
                                {{ quotation.client.postal_address }},<br />
                                {{ quotation.client.email }},
                                {{ quotation.client.phone }}
                            </p>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <h5 class="text-uppercase text-info mb-1 mt-3">
                                    DESCRIPTION:
                                </h5>
                                <p>{{ quotation.description }}</p>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <table class="table table-bordered">
                                <thead class="bg-secondary">
                                    <tr>
                                        <th>#</th>
                                        <th>PARTICULARS</th>
                                        <th>PRICE</th>
                                        <th>QUANTITY</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, i) in quotation.items" :key="i">
                                        <td>{{ i + 1 }}</td>
                                        <td>{{ item.particulars }}</td>
                                        <td class="text-right">
                                            {{ new
                                                    Intl.NumberFormat("en-US", {
                                                        style: "currency", currency: "KES"
                                                    }).format(item.price)
                                            }}
                                        </td>
                                        <td class="text-center">
                                            {{ item.quantity }}
                                        </td>
                                        <td class="text-right">
                                            {{ new
                                                    Intl.NumberFormat("en-US", {
                                                        style: "currency", currency: "KES"
                                                    }).format(item.amount)
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-secondary">
                                    <tr>
                                        <td class="text-right" colspan="4">
                                            TOTAL
                                        </td>
                                        <td class="text-right">
                                            {{ new
                                                    Intl.NumberFormat("en-US", {
                                                        style: "currency", currency: "KES"
                                                    }).format(quotation.amount)
                                            }}
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
                    <a :href="`/quotations/download/${quotation.id}`" class="btn btn-primary btn-round">
                        Download
                    </a>
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
            default: {
                id: null,
                name: null,
                created_at: null,
                amount: null,
                description: null,
                client: {
                    id: null,
                    name: "",
                    phone: "",
                    email: "",
                    postal_address: "",
                },
                items: [],
            },
        },
    },
    data() {
        return {
            selectedQuotation: {
                id: null,
                name: null,
                created_at: null,
                amount: null,
                description: null,
                client: {
                    id: null,
                    name: "",
                    phone: "",
                    email: "",
                    postal_address: "",
                },
                items: [],
            },
            title: "View Quotation",
        };
    },
    methods: {
        padChars(str, length, character, position = "left") {
            if (str) {
                console.log(str.toString())
                let chars = ""

                for (let i = 0; i < length - str.toString().length; i++) {
                    chars += character
                }
                return position.toLocaleLowerCase() === "left"
                    ? chars.concat(str)
                    : str.toString().concat(chars)
            }

        }
    },
    watch: {
        quotation(val) {
            this.selectedQuotation = val;
        },
    },
};
</script>
<style lang="scss">
.bg-secondary {
    background-image: linear-gradient(to bottom left,
            #344675,
            #263148,
            #344675);
    color: rgba(255, 255, 255, 0.7);

    tr {
        th {
            color: rgba(255, 255, 255, 0.7) !important;
        }
    }
}
</style>
