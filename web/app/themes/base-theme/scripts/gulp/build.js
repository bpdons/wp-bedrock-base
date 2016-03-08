/**
 * Build task that moves essential theme files for production-ready sites
 *
 * buildFiles copies all the files in buildInclude to build folder - check variable values at the top
 * buildImages copies all the images from img folder in assets while ignoring images inside raw folder if any
 */
module.exports = function (gulp, plugins, buildInclude, build, project, url, bower) {
    return function () {
        gulp.src(buildInclude)
            .pipe(gulp.dest(build))
            .pipe(plugins.notify({message: 'Copy from buildFiles complete', onLast: true}));

        // Look at src/images, optimize the images and send them to the appropriate place
        gulp.src(['assets/img/**/*', '!assets/images/raw/**'])
            .pipe(gulp.dest(build + 'assets/img/'))
            .pipe(plugins.notify({message: 'Images copied to buildTheme folder', onLast: true}));

        // Taking the build folder, which has been cleaned, containing optimized files and zipping it up to
        // send out as an installable theme
        gulp.src(build + '/**/')
            .pipe(plugins.zip(project + '.zip'))
            .pipe(gulp.dest('./'))
            .pipe(plugins.notify({message: 'Zip task complete', onLast: true}));

        // Package Distributable Theme
        gulp.task('build', function (cb) {
            plugins.runSequence('styles', 'cleanup', 'vendorsJs', 'scriptsJs', 'buildFiles', 'buildImages', 'buildZip', 'cleanupFinal', cb);
        });
    };
};