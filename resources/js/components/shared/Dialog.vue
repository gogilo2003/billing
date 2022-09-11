<template>
    <!-- Modal -->
    <div class="modal fade" ref="dialog" tabindex="-1" role="dialog" aria-labelledby="clientViewModal"
        aria-hidden="true" :data-backdrop="backdrop">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="close btn btn-link" @click="close" aria-label="Close">
                        <i class="tim-icons icon-simple-remove"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <slot #footer></slot>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    name: Dialog,
    props: {
        title: {
            type: String,
            default: "Dialog Title"
        },
        backdrop: {
            type: boolean,
            default: true
        },
        client: {
            type: Object,
            default: {}
        },
        show: {
            type: boolean,
            default: false
        }
    },
    data() {
        return {
            title: `View Client Details`
        }
    },
    methods: {
        close() {
            $(this.$refs.dialog).modal('hide')
        },
    }
}
</script>
