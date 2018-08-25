Nova.booting((Vue, router) => {
    Vue.component('algolia-resource-tool', require('./components/AlgoliaResourceTool'));

    router.addRoutes([
        {
            name: 'nova-algolia',
            path: '/nova-algolia',
            component: require('./components/AlgoliaPage'),
        },
    ])
})
