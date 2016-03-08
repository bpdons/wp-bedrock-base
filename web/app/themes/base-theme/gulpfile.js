/**
*
 * Gulpfile setup
 *
 * @since 1.0.0
 * @authors Ahmad Awais, @digisavvy, @desaiuditd, @jb510, @dmassiani and @Maxlopez, Ben Pitt
 * @package bedrock-base-WPGulp
 * @forks _s & some-like-it-neat & Advanced-Gulp-WordPress
 */


// Project configuration
var project = 'Tripod', // Project name, used for build zip.
    url = 'http://tripod.com.au', // Local Development URL for BrowserSync. Change as-needed.
    bower = './assets/bower_components/', // Not truly using this yet, more or less playing right now. TO-DO Place in Dev branch
    build = './wp-base/', // Files that you want to package into a zip go here
    buildInclude = [
    // include common file types
    '**/*.php',
    '**/*.html',
    '**/*.css',
    '**/*.js',
    '**/*.svg',
    '**/*.ttf',
    '**/*.otf',
    '**/*.eot',
    '**/*.woff',
    '**/*.woff2',

    // include specific files and folders
    'screenshot.png',

    // exclude files and folders
    '!node_modules/**/*',
    '!assets/bower_components/**/*',
    '!style.css.map',
    '!assets/js/custom/*',
    '!assets/css/partials/*'
];

// Load plugins
var gulp = require('gulp'),
    plugins = require('gulp-load-plugins')({
        camelize: true,
        pattern: '*'
    });

function getTask(task) {
    return require('./scripts/gulp/' + task)(gulp, plugins, buildInclude, build, project, url, bower);
}

// ==== TASKS ==== //

gulp.task('browser-sync', getTask('browser-sync'));
gulp.task('styles', getTask('sass'));
gulp.task('vendorsJs', getTask('vendor-js'));
gulp.task('scriptsJs', getTask('scripts'));
gulp.task('images', getTask('images'));
gulp.task('cleanup', getTask('cleanup'));
gulp.task('build', getTask('build'));


// Watch Task
gulp.task('default', ['styles', 'vendorsJs', 'scriptsJs', 'images', 'browser-sync'], function () {
    gulp.watch('./assets/img/raw/**/*', ['images']);
    gulp.watch('./assets/css/**/*.scss', ['styles']);
    gulp.watch('./assets/js/**/*.js', ['scriptsJs', plugins.browserSync.reload]);

});