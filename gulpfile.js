var gulp = require('gulp');
var browser = require('browser-sync').create();
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var inject = require('gulp-inject');
var imagemin = require('gulp-imagemin');
var clean = require('gulp-clean');

//GULP TASKS
gulp.task('default', ['develop']);
gulp.task('develop', [ 'clean', 'mock', 'scripts', 'styles', 'images', 'index:dev'], _develop);
gulp.task('build', ['clean', 'scripts', 'styles', 'index']);

gulp.task('index', _index);
gulp.task('index:dev', _devIndex);
gulp.task('scripts', ['clean:scripts'], _scripts);
gulp.task('styles', ['clean:styles'], _styles);
gulp.task('images', ['clean:images'], _images);
gulp.task('mock', _mock);
gulp.task('mock:watch', _watchMock);

gulp.task('clean', ['clean:index', 'clean:styles', 'clean:images', 'clean:mock', 'clean:scripts']);
gulp.task('clean:mock', _cleanMock);
gulp.task('clean:index', _cleanIndex);
gulp.task('clean:images', _cleanImages);
gulp.task('clean:styles', _cleanStyles);
gulp.task('clean:scripts', _cleanScripts);

//TASK FUNCTIONS
function _develop() {
    browser.init({
        server: "./dist/",
        tunnel: true
    });
    gulp.watch('./src/*.scss', ['styles']);
    gulp.watch('./src/**/*.js', ['scripts']);
    gulp.watch('./mock.js', ['mock:watch']).on('change', browser.reload);
    gulp.watch('./src/assets/**/*', ['images']);
    gulp.watch('./src/index.html').on('change', browser.reload);
}

//PARTIAL TASK FUNCTIONS
function _index() {
    gulp.src('./src/index.html')
        .pipe(gulp.dest('./dist'));
}

function _devIndex() {
    gulp.src('./src/index.html')
        .pipe(inject(gulp.src('./mock.js', {read:false, relative:true}), {starttag:'<!-- inject:mock -->'}))
        .pipe(gulp.dest('./dist/'))
        .pipe(browser.stream());
}

function _mock() {
    gulp.src('./mock.js')
        .pipe(gulp.dest('./dist/'))
        .pipe(browser.stream());
}

function _watchMock() {
    gulp.src('./mock.js')
        .pipe(gulp.dest('./dist/'));
}

function _cleanMock() {
    gulp.src('./dist/mock.js')
        .pipe(clean());
}

function _scripts() {
    gulp.src(['./src/jquery.js', './src/components/*js', './src/main.js'])
        .pipe(concat('main.js'))
        .pipe(gulp.dest('./dist/scripts'))
        .pipe(browser.stream());
}

function _styles() {
    gulp.src(['./src/styles.scss'])
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./dist/css'))
        .pipe(browser.stream());
}

function _images() {
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
}



//CLEAN-UP FUNCTIONS
function _cleanIndex() {
    gulp.src('./dist/index.html')
        .pipe(clean());
}

function _cleanImages() {
    return gulp.src('./dist/images/**/*')
        .pipe(clean());
}

function _cleanStyles() {
    return gulp.src('./dist/css/**/*')
        .pipe(clean());
}

function _cleanScripts() {
    return gulp.src(['./dist/scripts/**/*', '!./dist/scripts/mock.js'])
        .pipe(clean());
}






