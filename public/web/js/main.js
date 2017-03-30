require.config({
    baseUrl: "/web/js" ,
    paths: {
        jquery              : "libs/jquery-3.1.1.min",
        layer               : "libs/layer/mobile/layer",
        baiduTemplate       : "libs/baiduTemplate",
        dropload            : "libs/dropload-gh-pages/dist/dropload"
    },
    shim : {

        dropload  : {
            deps :  ['jquery']
        }
    }
});