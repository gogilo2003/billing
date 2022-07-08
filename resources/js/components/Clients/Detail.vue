<template>
    <!-- Modal -->
    <div class="modal fade" id="clientDetailModal" tabindex="-1" role="dialog" aria-labelledby="clientDetailModal"
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
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" placeholder="Enter name"
                                        v-model="client.name" id="inputName">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" v-model="client.phone"
                                        placeholder="Enter phone">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" v-model="client.email"
                                        placeholder="Enter email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="box_no">Box No</label>
                                    <input type="text" class="form-control" id="box_no" v-model="client.box_no"
                                        placeholder="Enter box no">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="post_code">Post Code</label>
                                    <input type="text" class="form-control" id="post_code" v-model="client.post_code"
                                        placeholder="Enter post code">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="town">Town</label>
                                    <input type="text" class="form-control" id="town" v-model="client.town"
                                        placeholder="Enter town">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" v-model="client.address"
                                        placeholder="Enter address">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close">Close</button>
                    <button type="button" class="btn btn-primary" @click="save">Save</button>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import { tsImportEqualsDeclaration } from '@babel/types'
import axios from 'axios'

export default {
    props: {
        edit: {
            type: Boolean,
            default: false
        },
        client: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            title: this.client.id ? "Edit client" : "New Client"
        }
    }
    , methods: {
        close() {
            $('#clientDetailModal').modal('hide')
        },
        save() {
            let url = `/api/clients?api_token=${window.API_TOKEN}`

            if (this.edit) {
                let data = {
                    id: this.client.id,
                    name: this.client.name,
                    phone: this.client.phone,
                    email: this.client.email,
                    box_no: this.client.box_no,
                    post_code: this.client.post_code,
                    town: this.client.town,
                    address: this.client.address
                }
                axios.patch(url, data)
                    .then(response => {
                        $.notify(
                            {
                                message: response.data.message,
                            },
                            {
                                type: "success",
                            }
                        );
                        this.$emit('updated', response.data.client)
                        this.close();
                    })
                    .catch(error => {
                        if (error.response.status == 415 || error.response.status == 422) {

                            $.notify(
                                {
                                    title: `<h4 class="text-white text-uppercase">${error.response.data.message}</h4>`,
                                    message: this.getErrors(error.response.data.errors),
                                },
                                {
                                    type: "danger",
                                }
                            );
                        } else {
                            console.log(error.response.data.message);
                        }
                    })
            } else {
                let data = {
                    name: this.client.name,
                    phone: this.client.phone,
                    email: this.client.email,
                    box_no: this.client.box_no,
                    post_code: this.client.post_code,
                    town: this.client.town,
                    address: this.client.address
                }
                axios.post(url, data)
                    .then(response => {
                        $.notify(
                            {
                                message: response.data.message,
                            },
                            {
                                type: "success",
                            }
                        );
                        this.edit = false
                        this.$emit('stored', response.data.client)
                        this.close();
                    })
                    .catch(error => {
                        if (error.response.status == 415 || error.response.status == 422) {

                            $.notify(
                                {
                                    title: `<h4 class="text-white text-uppercase">${error.response.data.message}</h4>`,
                                    message: this.getErrors(error.response.data.errors),
                                },
                                {
                                    type: "danger",
                                }
                            );
                        } else {
                            console.log(error.response.data.message);
                        }
                    })
            }

        },
        getErrors(errors) {
            let details = `<ol>`;
            for (const [key, value] of Object.entries(errors)) {
                details += `<li class="text-white">${value}</li>`;
            }
            details += `</ol>`
            return details
        },
    }
}
</script>
