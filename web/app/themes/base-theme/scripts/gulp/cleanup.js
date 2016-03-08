/**
 * Clean Gulp Cache
 * Clean tasks for zip
 *
 * Being a little overzealous, but we're cleaning out the build folder, codekit-cache directory and annoying DS_Store files and Also
 * clearing out unoptimized image files in zip as those will have been moved and optimized
 */
module.exports = function (gulp, plugins, buildInclude, build, project, url, bower) {
    return function () {
        plugins.cache.clearAll();

        // Cleanup
        gulp.src(['./assets/bower_components', '**/.sass-cache', '**/.DS_Store'], {read: false}) // much faster
            .pipe(plugins.ignore('node_modules/**')) //Example of a directory to ignore
            .pipe(plugins.rimraf({force: true}));
        // .pipe(notify({ message: 'Clean task complete', onLast: true }));
    };
};