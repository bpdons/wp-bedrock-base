/**
 * Scripts: Custom
 *
 * Look at src/js and concatenate those files, send them to assets/js where we then minimize the concatenated file.
 */
module.exports = function (gulp, plugins, buildInclude, build, project, url, bower) {
    return function () {
        gulp.src('./assets/js/custom/*.js')
            .pipe(plugins.concat('custom.js'))
            .pipe(gulp.dest('./assets/js'))
            .pipe(plugins.rename({
                basename: "custom",
                suffix: '.min'
            }))
            .pipe(plugins.uglify())
            .pipe(gulp.dest('./assets/js/'))
            .pipe(plugins.notify({message: 'Custom scripts task complete', onLast: true}));
    };
};