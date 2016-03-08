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
    }); // To automatically load in gulp plugins below

    /*
    var browserSync = require('browser-sync'), // Asynchronous browser loading on .scss file changes
    reload = browserSync.reload,
    autoprefixer = require('gulp-autoprefixer'), // Autoprefixing magic - prefix CSS for legacy browsers
    minifycss = require('gulp-uglifycss'), // For CSS Minification
    filter = require('gulp-filter'), // Enables you to work on a subset of the original files by filtering them using globbing.
    uglify = require('gulp-uglify'), // Minifies JS files
    imagemin = require('gulp-imagemin'), // Minifies PNG, JPEG, GIF and SVG images
    newer = require('gulp-newer'), // For passing through only those source files that are newer than corresponding destination files.
    rename = require('gulp-rename'), // To easily rename files
    concat = require('gulp-concat'), // To concatenate JS files
    notify = require('gulp-notify'), // To send notification to OS based on node notifier module
    cmq = require('gulp-combine-media-queries'), // To combine repetitive media queries after Sass or Less
    runSequence = require('gulp-run-sequence'), // Run a series of dependent gulp tasks in order
    sass = require('gulp-sass'), // Gulp plugin for Sass which is based on libSass
    ignore = require('gulp-ignore'), // Helps with ignoring files in the stream based on file characteristics
    rimraf = require('gulp-rimraf'), // Helps with removing files and directories in our run tasks
    zip = require('gulp-zip'), // Using to zip up our packaged theme into a tasty zip file that can be installed in WordPress!
    plumber = require('gulp-plumber'), // Fix node pipes, prevent them from breaking due to an error
    cache = require('gulp-cache'), // A cache proxy task for Gulp
    sourcemaps = require('gulp-sourcemaps'); // Source map support for CSS partial files
    */

function getTask(task) {
    return require('./scripts/gulp/' + task)(gulp, plugins, buildInclude, build, project, url, bower);
}

gulp.task('browser-sync', getTask('browser-sync'));
gulp.task('styles', getTask('sass'));
gulp.task('vendorsJs', getTask('vendor-js'));
gulp.task('scriptsJs', getTask('scripts'));
gulp.task('images', getTask('images'));
gulp.task('cleanup', getTask('cleanup'));
gulp.task('build', getTask('build'));



// ==== TASKS ==== //
/**
 * Gulp Default Task
 *
 * Compiles styles, fires-up browser sync, watches js and php files. Note browser sync task watches php files
 *
 */


// Watch Task
gulp.task('default', ['styles', 'vendorsJs', 'scriptsJs', 'images', 'browser-sync'], function () {
    gulp.watch('./assets/img/raw/**/*', ['images']);
    gulp.watch('./assets/css/**/*.scss', ['styles']);
    gulp.watch('./assets/js/**/*.js', ['scriptsJs', plugins.browserSync.reload]);

});