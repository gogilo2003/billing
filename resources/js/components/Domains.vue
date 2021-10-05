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
          <div
            class="col-md-6 d-flex"
            style="justify-content: flex-end; align-items: flex-start"
          >
            <!-- Button trigger modal -->
            <label
              class="btn btn-success btn-sm"
              @click="newDomain"
            >
              NEW
            </label>
            <label
              class="btn btn-dark btn-sm"
              @click="importDomains"
            >
              IMPORT
            </label>
            <div class="btn-group btn-group-toggle">
              <label
                class="btn btn-primary btn-sm btn-simple"
                :class="{ active: isActive }"
                for="activeDomainsRadio"
                >ACTIVE</label
              >
              <label
                class="btn btn-primary btn-sm btn-simple"
                :class="{ active: !isActive }"
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
                <th>Notify</th>
                <th></th>
              </tr>
            </thead>
            <tbody v-if="isActive">
              <tr v-for="(domain, index) in active.data" :key="domain.id">
                <td>{{ index + 1 }}</td>
                <td>{{ domain.domain }}</td>
                <td>{{ domain.registered_on }}</td>
                <td>{{ domain.expires_on }}</td>
                <td>{{ dateDiff(domain.expires_on) }}</td>
                <td>
                  <input
                    type="checkbox"
                    v-model="active.data[index].notify"
                    @change="setNotify(domain.id)"
                  />
                </td>
                <td>
                  <button class="btn btn-link" @click="editDomain(domain)">
                    <span class="tim-icons icon-pencil"></span>
                  </button>
                </td>
              </tr>
              <tr>
                <td colspan="7">
                  <div class="btn-group">
                    <button
                      @click="nextActivePage(active.links.first)"
                      style="cursor: pointer"
                      :disabled="
                        active.links.first == null ||
                        active.meta.current_page == 1
                      "
                      class="btn btn-sm btn-primary btn-simple"
                    >
                      <span class="tim-icons icon-double-left"></span>
                    </button>
                    <button
                      @click="nextActivePage(active.links.prev)"
                      style="cursor: pointer"
                      :disabled="active.links.prev == null"
                      class="btn btn-sm btn-primary btn-simple"
                    >
                      <span class="tim-icons icon-minimal-left"></span>
                    </button>
                    <button
                      @click="nextActivePage(active.links.next)"
                      style="cursor: pointer"
                      :disabled="active.links.next == null"
                      class="btn btn-sm btn-primary btn-simple"
                    >
                      <span class="tim-icons icon-minimal-right"></span>
                    </button>
                    <button
                      @click="nextActivePage(active.links.last)"
                      style="cursor: pointer"
                      :disabled="
                        active.links.last == null ||
                        active.meta.current_page == active.meta.last_page
                      "
                      class="btn btn-sm btn-primary btn-simple"
                    >
                      <span class="tim-icons icon-double-right"></span>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr v-for="(domain, index) in expired.data" :key="domain.id">
                <td>{{ index + 1 }}</td>
                <td>{{ domain.domain }}</td>
                <td>{{ domain.registered_on }}</td>
                <td>{{ domain.expires_on }}</td>
                <td>{{ dateDiff(domain.expires_on) }}</td>
                <td>
                  <input
                    type="checkbox"
                    v-model="expired.data[index].notify"
                    @change="setNotify(domain.id)"
                  />
                </td>
                <td>
                  <button class="btn btn-link" @click="editDomain(domain)">
                    <span class="tim-icons icon-pencil"></span>
                  </button>
                </td>
              </tr>
              <tr>
                <td colspan="7">
                  <div class="btn-group">
                    <button
                      @click="nextActivePage(expired.links.first)"
                      style="cursor: pointer"
                      :disabled="
                        expired.links.first == null ||
                        expired.meta.current_page == 1
                      "
                      class="btn btn-sm btn-primary btn-simple"
                    >
                      <span class="tim-icons icon-double-left"></span>
                    </button>
                    <button
                      @click="nextExpiredPage(expired.links.prev)"
                      style="cursor: pointer"
                      :disabled="expired.links.prev == null"
                      class="btn btn-sm btn-primary btn-simple"
                    >
                      <span class="tim-icons icon-minimal-left"></span>
                    </button>
                    <button
                      @click="nextExpiredPage(expired.links.next)"
                      style="cursor: pointer"
                      :disabled="expired.links.next == null"
                      class="btn btn-sm btn-primary btn-simple"
                    >
                      <span class="tim-icons icon-minimal-right"></span>
                    </button>
                    <button
                      @click="nextExpiredPage(expired.links.last)"
                      style="cursor: pointer"
                      :disabled="
                        expired.links.last == null ||
                        expired.meta.current_page == expired.meta.last_page
                      "
                      class="btn btn-sm btn-primary btn-simple"
                    >
                      <span class="tim-icons icon-double-right"></span>
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
    <domain :domain="selectedDomain" :edit.sync="edit"></domain>
    <import/>
  </div>
</template>
<script>
import mixins from "../mixins/mixins";
import Domain from "./Domain.vue";
import Import from "./Import.vue";
export default {
  data() {
    return {
      active: {
        data: [],
        links: {},
      },
      expired: { data: [], links: {} },
      clients: [],
      states: [],
      title: "New Domain",
      edit: false,
      isActive: true,
      selectedDomain: {
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
    Domain,
    Import
  },
  methods: {
    setNotify(id) {
      axios
        .post("/api/domains/notify", { id })
        .then((response) => {
          $.notify(
            {
              message: response.data.message,
              title: "Some title",
            },
            {
              type: "success",
            }
          );
        })
        .catch((error) => {
          console.log(error);
        });
    },
    importDomains(){
        $('#importModalDialog').modal('show')
    },
    newDomain() {
      this.selectedDomain = {
        domain: null,
        registered_on: null,
        expires_on: null,
        remarks: null,
        status: null,
        client_id: null,
      };
      this.edit = false;
      $('#domanisModalDialog').modal('show')
    },
    editDomain(domain) {
      this.edit = true;
      this.selectedDomain = domain;
      $("#domanisModalDialog").modal("show");
    },
    nextActivePage(url) {
      axios.get(url).then((response) => {
        this.active = response.data;
      });
    },
    nextExpiredPage(url) {
      axios.get(url).then((response) => {
        this.active = response.data;
      });
    },
    getDomains() {
      axios.get("/api/domains/active").then((response) => {
        this.active = response.data;
      });
      axios.get("/api/domains/expired").then((response) => {
        this.expired = response.data;
      });
    },
  },
  mounted() {
    this.getDomains();
  },
};
</script>
<style>
.modal-open .modal.show{
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
