<template>
    <div class="modal fade" id="domainsModalDialog" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="clientInput">Client</label>
                            <select class="form-control" name="clientInput" id="clientInput"
                                v-model="selectedDomain.client_id">
                                <option v-for="item in clients" :key="item.id" :value="item.id" v-html="item.name">
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="statusInput">Status</label>
                            <select class="form-control" name="statusInput" id="statusInput"
                                v-model="selectedDomain.status">
                                <option v-for="item in states" :key="item" :value="item" v-html="item"></option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="domainInput">Domain</label>
                            <input type="text" class="form-control" name="domainInput" id="domainInput"
                                aria-describedby="helpId" placeholder="Domain" v-model="selectedDomain.domain" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="registeredOnInput">Registered On</label>
                            <date-picker v-model="selectedDomain.registered_on" style="width: 100%"
                                placeholder="Expires On" :input-attr="{
                                    class: 'form-control',
                                    id: 'registeredOnInput',
                                }" value-type="format" format="YYYY-MM-DD HH:mm:ss">
                            </date-picker>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="expiresOnInput">Expires On</label>
                            <date-picker v-model="selectedDomain.expires_on" style="width: 100%"
                                placeholder="Expires On" :input-attr="{
                                    class: 'form-control',
                                    id: 'expiresOnInput',
                                }" value-type="format" format="YYYY-MM-DD HH:mm:ss">
                            </date-picker>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="remarksInput">Remarks</label>
                            <textarea v-model="selectedDomain.remarks" class="form-control" name="remarksInput"
                                id="remarksInput" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" @click="save()">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
export default {
    props: {
        domain: {
            type: Object,
            default: {
                domain: null,
                registered_on: null,
                expires_on: null,
                remarks: null,
                status: null,
                client_id: null,
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
            selectedDomain: {
                domain: null,
                registered_on: null,
                expires_on: null,
                remarks: null,
                status: null,
                client_id: null,
            },
            title: "Manage Domain",
            clients: [],
            states: [],
        };
    },
    methods: {
        getStatus() {
            axios.post("/api/domains/status").then((response) => {
                this.states = response.data;
            });
        },
        getClients() {
            axios.get("/api/clients").then((response) => {
                this.clients = response.data.data;
            });
        },
        save() {
            if (this.edit) {
                axios
                    .patch("/api/domains", this.selectedDomain)
                    .then((response) => {
                        $.notify(
                            {
                                message: response.data.message,
                            },
                            {
                                type: "success",
                            }
                        );
                        this.selectedDomain = {
                            domain: null,
                            registered_on: null,
                            expires_on: null,
                            remarks: null,
                            status: null,
                            client_id: null,
                        };
                        $("#domainsModalDialog").modal("hide");
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
                    .post("/api/domains", this.selectedDomain)
                    .then((response) => {
                        $.notify(
                            {
                                message: response.data.message,
                            },
                            {
                                type: "success",
                            }
                        );
                        this.selectedDomain = {
                            domain: null,
                            registered_on: null,
                            expires_on: null,
                            remarks: null,
                            status: null,
                            client_id: null,
                        };
                        $("#domainsModalDialog").modal("hide");
                        this.domains.unshift(response.data.domain);
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
    mounted() {
        this.getClients();
        this.getStatus();
    },
    watch: {
        domain(val) {
            this.selectedDomain = val;
        },
    },
    components: {
        DatePicker,
    },
};
</script>
