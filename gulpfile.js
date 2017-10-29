'use strict';

var gulp =              require( 'gulp' ),

    // Sass/CSS processes.
    bourbon =           require( 'bourbon' ).includePaths,
    neat =              require( 'bourbon-neat' ).includePaths,
    sass =              require( 'gulp-sass' ),
    postcss =           require( 'gulp-postcss' ),
    autoprefixer =      require( 'autoprefixer' ),
    //cssMQPacker =          require( 'css-mqpacker' ),
    sourcemaps =        require( 'gulp-sourcemaps' ),
    cssMinify =         require( 'gulp-cssnano' ),
    sassLint =          require( 'gulp-sass-lint' ),

    // Utilities
    rename =            require( 'gulp-rename' ),
    notify =            require( 'gulp-notify' ),
    plumber =           require( 'gulp-plumber' );

/***********************
 * Utilities
 **********************/

/**
 * Error handling.
 *
 * @function
 */
function handleErrors() {

    var args = Array.prototype.slice.call( arguments );

    notify.onError( {
        title:      'Task Failed [<%= error.message %>',
        message:    'See Console.',
        sound:      'Sosumi' // See: https://github.com/mikaelbr/node-notifier#all-notification-options-with-their-faults
    } ).apply( this, args );

    gutil.beep(); // Beep 'Sosumi' again.

    // Prevent the 'watch' task from stopping.
    this.emit( 'end' );

}

/***********************
 * CSS Tasks
 **********************/

/**
 * PostCSS Task Handler
 */
gulp.task( 'postcss', function () {

    return gulp.src( 'assets/sass/style.scss' )

        // Error handling.
        .pipe( plumber( {
            errorHandler: handleErrors
        } ) )

        // Writes tasks in a sourcemap.
        .pipe( sourcemaps.init() )

        // Compiles our Sass.
        .pipe( sass({
            includePaths:       [].concat( bourbon, neat ),
            errLogToConsole:    true,
            outputStyle:        'expanded' // Options: nested, expanded, compact, compressed.
        }) )

        // Parses out with the CSS.
        // We parse out through the CSS, and there are many tools we can use with it.
        .pipe( postcss( [
            autoprefixer( {
                browsers: ['last 2 versions']
            } )
            // cssMQPacker( {
            //     sort: true
            // } )
        ] ) )

        // Creates the sourcemap.
        .pipe( sourcemaps.write() )

        .pipe( gulp.dest( './' ) );

} );

// When we call 'cssMinify', then we also call 'styles'.
gulp.task( 'css:minify', ['postcss'], function () {

    return gulp.src( 'style.css' )

        // Error handling.
        .pipe( plumber( {
            errorHandler: handleErrors
        } ) )

        .pipe( cssMinify( {
            safe: true
        } ) )
        // We don't want to overwrite 'style.css', so we must rename our destination file.
        .pipe( rename( 'style.min.css' ) )
        .pipe( gulp.dest( './' ) )
        .pipe( notify( {
            message: 'Styles are built.'
        } ) )

} );

gulp.task( 'sass:lint', ['css:minify'], function () {

    gulp.src( [
        'assets/sass/style.css',
        '!assets/sass/base/html5-reset/_normalize.scss',
        '!assets/sass/utilities/animate/**/*.*'
    ] )

        .pipe( sassLint() )
        .pipe( sassLint.format() )
        .pipe( sassLint.failOnError() )

} );

/***********************
 * All Tasks Listeners
 **********************/

gulp.task( 'watch', function () {
    gulp.watch( 'assets/sass/**/*.scss', ['styles'] );
} );

/**
 * Individual Tasks.
 */
//gulp.task( 'scripts', [''] )
gulp.task( 'styles', ['sass:lint'] );

/**
 * CLARIFICATION OF THE ORDER IN THIS FILE
 *
 * This is very similar to PHP functions.
 * We create a gulp.task( 'cssMinify', ['postcss'] ), function{...} (like a PHP function) that calls something else.
 * So, if we call 'watch', then it goes and calls 'styles', which in turn calls cssMinify,
 * which has a dependency ['postcss'] (which it calls). When it is called, 'postcss' runs cssMinify.
 * So, first cssMinify calls postcss which then runs cssMinify in its function.
 * Then, the true order is watch->styles->postcss->cssMinify.
 * JavaScript functions don't wait for other functions to run (so it is asynchronous).
 * The fact that 'styles' runs doesn't mean that all the code is executed.
 * So, at this stage of our file, it is asynchronous. When we reach the modular part, it will be synchronous.
 *
 * If we now run gulp styles in our Terminal, we will see the running order of things:
 *
 * [13:15:34] Using gulpfile /home/themes/domains/cam-beta-micro.com/public/wp-content/themes/cam-beta-micro/gulpfile.js
 * [13:15:34] Starting 'postcss'...
 * [13:15:34] Finished 'postcss' after 253 ms
 * [13:15:34] Starting 'cssMinify'...
 * [13:15:34] Finished 'cssMinify' after 6.13 μs
 * [13:15:34] Starting 'styles'...
 * [13:15:34] Finished 'styles' after 9.35 μs
 */