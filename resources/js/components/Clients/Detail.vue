<template>
    <!-- Modal -->
    <div class="modal fade" id="clientDetailModal" tabindex="-1" role="dialog" aria-labelledby="clientDetailModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="btn-close btn btn-link" @click="close" aria-label="Close">
                        <i class="tim-icons icon-simple-remove"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <code>{{ client }}</code>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="close">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
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
            title: this.edit ? "Edit client" : "New Client"
        }
    }, methods: {
        close() {
            $('#clientDetailModal').modal('hide')
        }
    }
}
</script>
