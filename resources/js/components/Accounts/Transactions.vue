<template>
    <modal :show="show" :title="title">
        <template #body>
            <div>{{ accounts }}</div>
        </template>
    </modal>
</template>
<script>
export default {
    props: {
        show: { default: false },
        accounts: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            title: `View Client Accounts`
        }
    }
}
</script>
