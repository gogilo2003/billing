<template>
    <div class="modal fade" id="importModalDialog" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
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
                        <div class="form-group col-md-12">
                            <label class="custom-file">
                                <input type="file" name="csv" id="csv" ref="file" placeholder="Select File"
                                    class="custom-file-input" aria-describedby="importFileHelpId" />
                                <span class="custom-file-control">Select a file</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" @click="save()">
                        Upload
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            file: null,
            title: "Import Domains",
        };
    },
    methods: {
        save() {
            let data = new FormData();
            let csv_file = this.$refs.file.files[0]
            if (csv_file) {
                data.append("csv_file", csv_file);
            }

            axios
                .post("/api/domains/import", data)
                .then((response) => {
                    $.notify(
                        {
                            message: response.data.message,
                        },
                        {
                            type: "success",
                        }
                    );
                    this.file = null;
                    $("#importModalDialog").modal("hide");
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
                                type: "danger"
                            }
                        );
                    } else {
                        console.log(error.response.data.message);
                    }
                });
        },
    },
};
</script>
<style>
</style>
