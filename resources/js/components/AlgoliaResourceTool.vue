<template>
    <loading-card v-if="loading" class="h-12 shadow-none"></loading-card>
    <div v-else>
        <h3 class="mr-3 text-base text-80 font-bold">Index</h3>
        <div class="flex items-center mb-4">
            <p class="text-4xl mr-auto" v-text="algoliaData.index"></p>

            <button @click="importRecord" title="Import" class="appearance-none cursor-pointer text-70 hover:text-primary mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="import" role="presentation" class="fill-current"><path fill-rule="nonzero" d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"></path></svg></button>
            <button @click="openConfirmRemoval" title="Remove" class="appearance-none cursor-pointer text-70 hover:text-danger mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="delete" role="presentation" class="fill-current"><path fill-rule="nonzero" d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z"></path></svg></button>
        </div>
        <pre v-if="algoliaData.data"><code v-text="algoliaData.data"></code></pre>
        <pre v-else>This model doesn't have a record in Algolia.</pre>

        <portal to="modals">
            <modal v-if="showingConfirmRemoval" @modal-close="closeConfirmRemoval">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="width: 460px;">
                    <div class="p-8">
                        <h2 class="mb-6 text-90 font-normal text-xl">Remove Record</h2>
                        <p class="text-80 leading-normal">Are you sure you want to remove this record from the search index?</p>
                    </div>
                    <div class="bg-30 px-6 py-3 flex">
                        <div class="ml-auto">
                            <button @click="closeConfirmRemoval" class="btn text-80 font-normal h-9 px-3 mr-3 btn-link">Cancel</button>
                            <button @click="removeRecord" class="btn btn-default btn-danger">Remove</button>
                        </div>
                    </div>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
    export default {
        props: ['resourceName', 'resourceId', 'field'],

        data: function () {
            return {
                algoliaData: [],
                loading: true,
                showingConfirmRemoval: false,
                path: `/nova-vendor/nova-algolia/${encodeURI(this.field.resourceClass)}/${this.resourceId}`,
            }
        },

        mounted() {
            Nova.request(this.path).then(({data}) => {
                this.algoliaData = data;
                this.loading = false;
            });
        },

        methods: {
            importRecord: function () {
                Nova.request().post(this.path).then(({data}) => {
                    this.algoliaData = data;
                });
            },

            removeRecord: function () {
                this.closeConfirmRemoval();
                Nova.request().delete(this.path).then(({data}) => {
                    this.algoliaData = data;
                });
            },

            openConfirmRemoval: function () {
                this.showingConfirmRemoval = true;
            },

            closeConfirmRemoval: function () {
                this.showingConfirmRemoval = false;
            },
        },
    }
</script>
