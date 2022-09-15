var gulp = require( 'gulp' ),
	sass = require( 'gulp-sass' ),
	postcss = require( 'gulp-postcss' ),
	autoprefixer = require( 'autoprefixer' ),
	cssnano = require( 'cssnano' ),
	sourcemaps = require( 'gulp-sourcemaps' );
	browserSync = require( 'browser-sync' ).create();
	concat = require( 'gulp-concat' );
	paths = {
		styles: {
			src: 'assets/src/scss/*.scss',
			dest: 'assets/build/css/'
		},
		theme: {
			src: '**/*.php'
		}
	};

// Style task.
function style() {
	return (
		gulp
			.src( paths.styles.src )
			.pipe( sourcemaps.init() )
			.pipe( sass() )
			.on( 'error', sass.logError )
			.pipe( postcss([ autoprefixer(), cssnano() ]) )
			.pipe( sourcemaps.write() )
			.pipe( gulp.dest( paths.styles.dest ) )
			.pipe( browserSync.stream() )
	);
}

// BrowserSync Reload task.
function reload() {
	browserSync.reload();
}

// Watch tasks.
function watch() {
	gulp.watch( paths.styles.src, style );
	gulp.watch( paths.theme.src, reload );
}

// Serve task.
function serve() {
	browserSync.init({
		proxy: 'http://localhost:10043/'
	});
}

// Default Task.
const defaultTasks = gulp.series(
	style,
	gulp.parallel(
		serve,
		watch
	)
);

// Task exports.
exports.serve = serve;
exports.watch = watch;
exports.reload = reload;
exports.style = style;
exports.default = defaultTasks;