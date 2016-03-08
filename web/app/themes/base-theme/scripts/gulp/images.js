/**
 * Images
 *
 * Look at src/images, optimize the images and send them to the appropriate place
 */
module.exports = function (gulp, plugins, buildInclude, build, project, url, bower) {
    return function () {
        gulp.src(['./assets/img/raw/**/*.{png,jpg,gif}'])
            .pipe(plugins.newer('./assets/img/'))
            .pipe(plugins.rimraf({force: true}))
            .pipe(plugins.imagemin({optimizationLevel: 7, progressive: true, interlaced: true}))
            .pipe(gulp.dest('./assets/img/'))
            .pipe(plugins.notify({message: 'Images task complete', onLast: true}));
    };
};