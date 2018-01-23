var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');

gulp.task('sass', function() {
    gulp.src('public/sass/**/*.scss')
        .pipe(concat('app.css'))
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(gulp.dest('public/css/'));
});

//Watch task
gulp.task('watch',function() {
    gulp.watch('public/sass/**/*.scss',['sass']);
});
