/**
 * Scripts: Vendors
 *
 * Look at src/js and concatenate those files, send them to assets/js where we then minimize the concatenated file.
 */
module.exports = function (gulp, plugins, buildInclude, build, project, url, bower) {
    return function () {
        gulp.src(['./assets/js/vendor/**/*.js', bower + '**/*.js'])
            .pipe(plugins.concat('vendors.js'))
            .pipe(gulp.dest('./assets/js'))
            .pipe(plugins.rename({
                basename: "vendors",
                suffix: '.min'
            }))
            .pipe(plugins.uglify())
            .pipe(gulp.dest('./assets/js/'))
            .pipe(plugins.notify({message: 'Vendor scripts task complete', onLast: true}));
    };
};