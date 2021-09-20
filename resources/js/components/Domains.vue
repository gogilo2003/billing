<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6 text-uppercase">
            <h3 class="card-title">Domains</h3>
            <h5 class="card-title" v-if="isActive">Active Domains</h5>
            <h5 class="card-title" v-else>Expired Domains</h5>
          </div>
          <div class="col-md-6 d-flex" style="justify-content:flex-end; align-items:flex-start">
            <!-- Button trigger modal -->
            <label
              class="btn btn-dark btn-sm"
              data-toggle="modal"
              data-target="#domanisModalDialog"
              @click="newDomain"
            >
              NEW
            </label>
            <div class="btn-group btn-group-toggle">
              <label
                class="btn btn-primary btn-sm btn-simple"
                :class="{ active: isActive}"
                for="activeDomainsRadio"
                >ACTIVE</label
              >
              <label
                class="btn btn-primary btn-sm btn-simple"
                :class="{ active: !isActive}"
                for="expiredDomainsRadio"
                >EXPIRED</label
              >
            </div>
            <input
              type="radio"
              name="test"
              id="activeDomainsRadio"
              :value="true"
              v-model="isActive"
              v-show="false"
              checked
            />
            <input
              type="radio"
              name="test"
              id="expiredDomainsRadio"
              :value="false"
              v-model="isActive"
              v-show="false"
            />
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
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
            <tbody v-if="isActive">
              <tr v-for="(domain, index) in domains.active" :key="domain.id">
                <td>{{ index + 1 }}</td>
                <td>{{ domain.domain }}</td>
                <td>{{ domain.registered_on }}</td>
                <td>{{ domain.expires_on }}</td>
                <td>{{ dateDiff(domain.expires_on) }}</td>
                <td>
                  <button class="btn btn-link" @click="editDomain(domain)">
                    <span class="tim-icons icon-pencil"></span>
                  </button>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr v-for="(domain, index) in domains.expired" :key="domain.id">
                <td>{{ index + 1 }}</td>
                <td>{{ domain.domain }}</td>
                <td>{{ domain.registered_on }}</td>
                <td>{{ domain.expires_on }}</td>
                <td>{{ dateDiff(domain.expires_on) }}</td>
                <td>
                  <button class="btn btn-link" @click="editDomain(domain)">
                    <span class="tim-icons icon-pencil"></span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
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
                  v-model="domain.client_id"
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
                  v-model="domain.status"
                >
                  <option
                    v-for="item in states"
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
                <label for="expiresOnInput">Expires On</label>
                <!-- <input
                  type="date"
                  class="form-control"
                  name="expiresOnInput"
                  id=""
                  aria-describedby="helpId"
                  placeholder="Expires On"
                  v-model="domain.expires_on"
                /> -->
                <date-picker
                  input-class="form-control"
                  v-model="domain.expires_on"
                  style="width: 100%"
                >
                </date-picker>
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
import mixins from "../mixins/mixins";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
export default {
  data() {
    return {
      domains: {},
      clients: [],
      states: [],
      title: "New Domain",
      edit: false,
      isActive: true,
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
  mixins: [mixins],
  components: {
    DatePicker,
  },
  methods: {
    newDomain() {
      this.domain = {
        domain: null,
        registered_on: null,
        expires_on: null,
        remarks: null,
        status: null,
        client_id: null,
      };
      this.edit = false;
    },
    editDomain(domain) {
      this.edit = true;
      this.domain = domain;
      $("#domanisModalDialog").modal("show");
    },
    getDomains() {
      axios.get("/api/domains").then((response) => {
        this.domains.active = response.data.domains.active.data;
        this.domains.expired = response.data.domains.expired.data;
      });
    },
    getStatus() {
      axios.get("/api/domains/status").then((response) => {
        this.states = response.data;
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
            $("#domanisModalDialog").modal("hide");
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
            $("#domanisModalDialog").modal("hide");
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
