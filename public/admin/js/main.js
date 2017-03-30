require.config({
    baseUrl: "/admin/js" ,
    paths: {
        jquery          : "libs/jquery-3.1.1.min",
        dmuploader      : "libs/dmuploader",
        layer           : "libs/layer/layer",
        paginate        : "libs/paginate/jquery.paginate",
        sortable        : "libs/jquery.fn.sortable",
        baiduTemplate   : "libs/baiduTemplate",
    },
    shim : {
        dmuploader  : {
            deps :  ['jquery']
        },
        layer  : {
            deps :  ['jquery']
        },
        paginate  : {
            deps :  ['jquery']
        },
        sortable : {
            deps :  ['jquery']
        }
    }
});