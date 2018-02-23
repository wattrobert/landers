var gulp = require('gulp');
var browser = require('browser-sync').create();
var sass = require('gulp-sass');
var inject = require('gulp-inject');
var imagemin = require('gulp-imagemin');
var clean = require('gulp-clean');
var ext = require('gulp-ext-replace');
var path = require('path');

gulp.task('clean', ['clean:index', 'clean:styles', 'clean:kowboykit', 'clean:images']);

gulp.task('clean:images', function() {
    return gulp.src('./dist/images/**/*')
        .pipe(clean());
})
gulp.task('clean:styles', function() {
    return gulp.src('./dist/css/**/*')
        .pipe(clean());
})
gulp.task('clean:scripts', function() {
    return gulp.src('./dist/scripts/**/*')
        .pipe(clean());
})
gulp.task('clean:kk', function() {
    return gulp.src(['./dist/**/*.php'])
        .pipe(clean());
})
gulp.task('styles', ['clean:styles'], function() {
    gulp.src(['./src/styles.scss'])
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./dist/css'))
        .pipe(browser.stream());
})
gulp.task('scripts', ['clean:scripts'], function() {
    gulp.src(['./src/main.js'])
        .pipe(gulp.dest('./dist/scripts'))
        .pipe(browser.stream());
})
gulp.task('images', ['clean:images'], function() {
    gulp.src('./src/assets/images/**/*')
        .pipe(imagemin([
            imagemin.gifsicle({interlaced: true}),
            imagemin.jpegtran({progressive: true}),
            imagemin.optipng({optimizationLevel: 5}),
            imagemin.svgo({
                plugins: [
                    {removeViewBox: true},
                    {cleanupIDs: false}
                ]
            })
        ]))
        .pipe(gulp.dest('./dist/assets/images'))
        .pipe(browser.stream());
})

gulp.task('kk', ['clean:kk', 'kk-root', 'kk-api', 'kk-includes'])

gulp.task('kk-api', function() {
    gulp.src('./src/kowboykit/api/*')
        .pipe(gulp.dest('./dist/kowboykit/api'));
})

gulp.task('kk-includes', function() {
    gulp.src('./src/kowboykit/includes/*')
        .pipe(gulp.dest('./dist/kowboykit/includes'));
})

gulp.task('kk-root', function() {
    gulp.src(['./src/kowboykit/exit.php', './src/kowboykit/thank-you.php'])
        .pipe(gulp.dest('./dist'));
})

gulp.task('build', ['clean:index', 'scripts', 'styles', 'images', 'kk'], function() {
    gulp.src('./src/index.html')
        .pipe(ext('.php'))
        .pipe(gulp.dest('./dist'));
})

gulp.task('clean:index', function() {
    gulp.src('./dist/index.html')
        .pipe(clean())
})

gulp.task('develop', ['index', 'scripts', 'styles', 'images', 'kk'], function() {
    browser.init({
        server: "./dist/"
    })
    gulp.watch('./src/*.scss', ['styles']);
    gulp.watch('./src/*.js', ['scripts']);
    gulp.watch('./src/assets/**/*', ['images']);
    gulp.watch('./src/index.html', ['index']).on('change', browser.reload)
})

gulp.task('index', function() {
    gulp.src('./src/index.html')
        .pipe(gulp.dest('./dist'));
})

gulp.task('serve', function() {
    browser.init({
        server: "./dist/"
    })
})

gulp.task('default', ['develop']);