<template>
  <div>
    <div class="card">
      <div class="card-header">
        <h1 class="card-title">Domains</h1>
        <!-- Button trigger modal -->
        <button
          type="button"
          class="btn btn-primary"
          data-toggle="modal"
          data-target="#domanisModalDialog"
        >
          New
        </button>
      </div>
      <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Domain</th>
                    <th>Registered On</th>
                    <th>Expires On</th>
                    <th>Days</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(domain, index) in domains" :key="index">
                    <td>{{ index +1 }}</td>
                    <td>{{ domain.domain }}</td>
                    <td>{{ domain.registered_on }}</td>
                    <td>{{ domain.expires_on }}</td>
                    <td>{{ domain.expires_on }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="domanisModalDialog"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ title }}</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-8">
                <label for="clientInput">Client</label>
                <select
                  class="form-control"
                  name="clientInput"
                  id="clientInput"
                  v-model="domain.client"
                >
                  <option
                    v-for="item in clients"
                    :key="item.id"
                    :value="item.id"
                    v-html="item.name"
                  ></option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="statusInput">Status</label>
                <select
                  class="form-control"
                  name="statusInput"
                  id="statusInput"
                  v-model="domain.state"
                >
                  <option
                    v-for="item in status"
                    :key="item"
                    :value="item"
                    v-html="item"
                  ></option>
                </select>
              </div>
              <div class="form-group col-md-12">
                <label for="domainInput">Domain</label>
                <input
                  type="text"
                  class="form-control"
                  name="domainInput"
                  id="domainInput"
                  aria-describedby="helpId"
                  placeholder="Domain"
                  v-model="domain.domain"
                />
              </div>
              <div class="form-group col-md-6">
                <label for="registeredOnInput">Registered On</label>
                <input
                  type="date"
                  class="form-control"
                  name="registeredOnInput"
                  id=""
                  aria-describedby="helpId"
                  placeholder="Registered On"
                  v-model="domain.registered_on"
                />
              </div>
              <div class="form-group col-md-6">
                <label for="expitersOnInput">Expires On</label>
                <input
                  type="date"
                  class="form-control"
                  name="expitersOnInput"
                  id=""
                  aria-describedby="helpId"
                  placeholder="Expires On"
                  v-model="domain.expires_on"
                />
              </div>
              <div class="form-group col-md-12">
                <label for="remarksInput">Remarks</label>
                <textarea
                  v-model="domain.remarks"
                  class="form-control"
                  name="remarksInput"
                  id="remarksInput"
                  rows="3"
                ></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button type="button" class="btn btn-primary" @click="save()">
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      domains: [],
      clients: [],
      status: [],
      title: "New Domain",
      edit: false,
      domain: {
        domain: null,
        registered_on: null,
        expires_on: null,
        remarks: null,
        status: null,
        client_id: null,
      },
    };
  },
  methods: {
    getDomains() {
      axios.get("/api/domains").then((response) => {
        this.domains = response.data.data;
      });
    },
    getStatus() {
      axios.get("/api/domains/status").then((response) => {
        this.status = response.data;
      });
    },
    getClients() {
      axios.get("/api/clients").then((response) => {
        this.clients = response.data;
      });
    },
    save() {
      if (this.edit) {
        axios
          .patch("/api/domains", this.domain)
          .then((response) => {
            $.notify(
              {
                message: response.data.message,
              },
              {
                z_index: 9999,
                type: "success",
              }
            );
            this.domain = {
              domain: null,
              registered_on: null,
              expires_on: null,
              remarks: null,
              status: null,
              client_id: null,
            };
            $('#domanisModalDialog').modal('hide')
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axios
          .post("/api/domains", this.domain)
          .then((response) => {
            $.notify(
              {
                message: response.data.message,
              },
              {
                z_index: 9999,
                type: "success",
              }
            );
            this.domain = {
              domain: null,
              registered_on: null,
              expires_on: null,
              remarks: null,
              status: null,
              client_id: null,
            };
            $('#domanisModalDialog').modal('hide')
            this.domains.unshift(response.data.domain)
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
                  z_index: 9999,
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
    this.getDomains();
    this.getClients();
    this.getStatus();
    // $.notify(
    //   {
    //     message: "Welcome here",
    //     title: "Test",
    //   },
    //   { z_index: 9000 }
    // );
  },
};
</script>
