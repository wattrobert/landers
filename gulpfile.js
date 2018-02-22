var gulp = require('gulp');
var sass = require('gulp-sass');
var inject = require('gulp-inject');
var imagemin = require('gulp-imagemin');
var clean = require('gulp-clean');

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
    return gulp.src('./dist/**/*.php')
        .pipe(clean());
})
gulp.task('styles', ['clean:styles'], function() {
    gulp.src(['./src/styles.scss'])
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./dist/css'));
})
gulp.task('scripts', ['clean:scripts'], function() {
    gulp.src(['./src/main.js'])
        .pipe(gulp.dest('./dist/scripts'))
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
        .pipe(gulp.dest('./dist/assets/images'));
})

gulp.task('kk', ['clean:kk', 'kk-root'], function() {
    gulp.src(['./src/kowboykit/**/*.php'])
        .pipe(gulp.dest('./dist/kowboykit'));
})

gulp.task('kk-root', function() {
    gulp.src(['./src/kowboykit/exit.php', './src/kowboykit/thank-you.php'])
        .pipe(gulp.dest('./dist'));
})

gulp.task('default', ['scripts', 'styles', 'images', 'kk'], function() {
    gulp.src('./src/index.html')
        .pipe(gulp.dest('./dist'));
})

gulp.task('watch', ['default'], function() {
    gulp.watch('./src/*.scss', ['styles']);
    gulp.watch('./src/*.js', ['scripts']);
    gulp.watch('./src/assets/**/*', ['images']);
    
})