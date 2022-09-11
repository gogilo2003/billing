<template>
    <!-- Modal -->
    <div @click="backdropClick" class="modal fade" :class="{show:showModal}" ref="dialog" tabindex="-1" role="dialog"
        aria-hidden="true" :data-backdrop="backdrop" :style="displayDialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="close btn btn-link" @click="toggleModal" aria-label="Close">
                        <i class="tim-icons icon-simple-remove"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <slot name="body">
                        <h1>This is a modal</h1>
                    </slot>
                </div>
                <div class="modal-footer">
                    <slot name="footer">
                        <p>this is footer</p>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "modal",
    props: {
        title: { default: "Modal Title" },
        backdrop: { default: "static" },
        show: true
    },
    data() {
        return {
            showModal: false
        }
    },
    computed: {
        displayDialog() { return `display: ${this.showModal ? 'block' : 'none'}` }
    },
    watch: {
        show() {
            this.toggleModal()
        }
    },
    methods: {
        toggleModal() {
            this.showModal = !this.showModal
            this.$emit('closed', this.showModal)
        },
        backdropClick() {
            if (this.backdrop !== 'static') {
                this.toggleModal()
            }
        }
    },
    mounted() {
        this.showModal = this.show
    },

}
</script>
