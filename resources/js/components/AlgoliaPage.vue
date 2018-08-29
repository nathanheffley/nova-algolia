<template>
    <div>
        <heading class="mb-6">Algolia</heading>

        <card class="card px-6 py-4" v-for="index in indexes" :key="index.name">
            <div class="flex mb-4 items-center">
                <h3 class="mr-3 text-2xl text-80 font-normal" v-text="index.name"></h3>
                <p class="ml-auto">Last Updated: {{ index.updatedAt }}</p>
            </div>
            <div class="flex items-center">
                <p class="text-4xl mr-auto">{{ index.entries }} {{ 'record' | pluralize(index.entries) }}</p>
                <button @click="importRecords(index.name)" title="Import" class="appearance-none cursor-pointer text-70 hover:text-primary mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="import" role="presentation" class="fill-current"><path fill-rule="nonzero" d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"></path></svg></button>
                <button @click="openConfirmFlush(index.name)" title="Flush" class="appearance-none cursor-pointer text-70 hover:text-danger mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="delete" role="presentation" class="fill-current"><path fill-rule="nonzero" d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z"></path></svg></button>
            </div>
        </card>

        <portal to="modals">
            <modal v-if="flushName" @modal-close="closeConfirmFlush">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="width: 460px;">
                    <div class="p-8">
                        <h2 class="mb-6 text-90 font-normal text-xl">Flush Index</h2>
                        <p class="text-80 leading-normal">Are you sure you want to flush this index?</p>
                    </div>
                    <div class="bg-30 px-6 py-3 flex">
                        <div class="ml-auto">
                            <button @click="closeConfirmFlush" class="btn text-80 font-normal h-9 px-3 mr-3 btn-link">Cancel</button>
                            <button @click="flush" class="btn btn-default btn-danger">Flush</button>
                        </div>
                    </div>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
export default {
    data: () => {
        return {
            indexes: [],
            flushName: null,
        }
    },

    mounted() {
        Nova.request('/nova-vendor/nova-algolia/indexes').then(({data}) => {
            this.indexes = data.items;
        });
    },

    methods: {
        importRecords: function (name) {
            Nova.request().post('/nova-vendor/nova-algolia/indexes/' + name + '/import').then(({data}) => {
                let index = this.indexes.find((index) => {
                    return index.name === name
                });

                index.entries = data;
            })
        },

        closeConfirmFlush: function () {
            this.flushName = null;
        },

        openConfirmFlush: function (name) {
            this.flushName = name;
        },

        flush: function () {
            Nova.request().post('/nova-vendor/nova-algolia/indexes/' + this.flushName + '/flush').then(({data}) => {
                let index = this.indexes.find((index) => {
                    return index.name === this.flushName
                });

                index.entries = 0;
                index.updatedAt = data.updatedAt;

                this.flushName = '';
            })
        }
    },

    filters: {
        pluralize: function (word, count) {
            if (count === 1) {
                return word
            } else {
                return word + 's'
            }
        }
    },
}
</script>

<style>
    .card + .card {
        margin-top: 1.5rem;
    }
</style>
