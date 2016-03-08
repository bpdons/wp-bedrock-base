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

        var fontName = 'iconfont-icons';
        gulp.src(['./assets/icons/*.svg'])
            .pipe(plugins.iconfontCss({
                fontName: fontName,
                path: './node_modules/gulp-iconfont-css/templates/_icons.scss',
                targetPath: '../../css/partials/_icons.scss',
                fontPath: '../fonts/icons/'
            }))
            .pipe(plugins.iconfont({
                fontName: fontName
            }))
            .pipe(gulp.dest('./assets/fonts/icons/'))
            .pipe(plugins.notify({message: 'Font icons generated', onLast: true}));

    };
};