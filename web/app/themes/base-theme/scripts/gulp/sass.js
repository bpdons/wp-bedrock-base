/**
 * Styles
 *
 * Looking at src/sass and compiling the files into Expanded format, Autoprefixing and sending the files to the build folder
 *
 * Sass output styles: https://web-design-weekly.com/2014/06/15/different-sass-output-styles/
 */
module.exports = function (gulp, plugins, buildInclude, build, project, url, bower) {
    return function () {
        gulp.src('./assets/css/partials/*.scss')
            .pipe(plugins.plumber())
            .pipe(plugins.sourcemaps.init())
            .pipe(plugins.sass({
                includePaths: ['node_modules/motion-ui/src'],
                errLogToConsole: true,

                //outputStyle: 'compressed',
                outputStyle: 'compact',
                // outputStyle: 'nested',
                // outputStyle: 'expanded',
                precision: 10
            }))
            .pipe(plugins.sourcemaps.write({includeContent: false}))
            .pipe(plugins.sourcemaps.init({loadMaps: true}))
            .pipe(plugins.autoprefixer('last 2 version', '> 1%', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
            .pipe(plugins.sourcemaps.write('.'))
            .pipe(plugins.plumber.stop())
            .pipe(gulp.dest('./'))
            .pipe(plugins.filter('**/*.css')) // Filtering stream to only css files
            .pipe(plugins.combineMediaQueries()) // Combines Media Queries
            .pipe(plugins.browserSync.reload({stream: true})) // Inject Styles when style file is created
            .pipe(plugins.rename({suffix: '.min'}))
            .pipe(plugins.uglifycss({
                maxLineLen: 80
            }))
            .pipe(gulp.dest('./'))
            .pipe(plugins.browserSync.reload({stream: true})) // Inject Styles when min style file is created
            .pipe(plugins.notify({message: 'Styles task complete', onLast: true}))
    };
};