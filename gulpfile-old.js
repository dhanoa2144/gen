const { series, src, dest } = require( 'gulp' );
const minify = require("gulp-minify");
const rename = require('gulp-rename');

function dev() {
    return src( 'assets/src/js/*.js' )
        .pipe( rename({ extname: '.dev.js' }) )
        .pipe( dest( 'assets/build/js/' ) );
}

function prod() {
    return src( 'assets/src/js/*.js' )
        .pipe( minify() )
        .pipe( rename({ extname: '.js' }) )
        .pipe( dest( 'assets/build/js/' ) );
}


exports.default = dev;
exports.dev = dev;
exports.prod = prod;
