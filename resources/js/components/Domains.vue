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
          data-target="#modelId"
        >
          New
        </button>
      </div>
      <div class="card-body">
        {{ domains }}
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="modelId"
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
          })
          .catch((error) => {
            console.log(error.response.data.details);
            $.notify(
              {
                title: `<h4>${error.response.data.message}</h4>`,
                message: '',
              },
              {
                z_index: 9999,
                type: "danger",
              }
            );
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
