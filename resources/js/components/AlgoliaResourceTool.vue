<template>
    <div>
        <h3 class="mr-3 text-base text-80 font-bold">Index</h3>
        <div class="flex items-center">
            <p class="text-4xl mb-4 mr-auto" v-text="algoliaData.index"></p>
        </div>
        <pre><code v-text="algoliaData.data"></code></pre>
    </div>
</template>

<script>
    export default {
        props: ['resourceName', 'resourceId', 'field'],

        data: () => {
            return {
                'algoliaData': [],
            }
        },

        mounted() {
            let path = `/nova-vendor/nova-algolia/${this.resourceName}/${this.resourceId}`;

            Nova.request(path).then(({data}) => {
                this.algoliaData = data;
            });
        }
    }
</script>
