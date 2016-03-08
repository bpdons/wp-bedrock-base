module.exports = function (gulp, plugins, buildInclude, build, project, url, bower) {
    return function () {
        var files = [
            '**/*.php',
            '**/*.{png,jpg,gif}'
        ];
        plugins.browserSync.init(files, {

            // Read here http://www.browsersync.io/docs/options/
            proxy: url,

            // port: 8080,

            // Tunnel the Browsersync server through a random Public URL
            // tunnel: true,

            // Attempt to use the URL "http://my-private-site.localtunnel.me"
            // tunnel: "ppress",

            // Inject CSS changes
            injectChanges: true

        });
    };
};