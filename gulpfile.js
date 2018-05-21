var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer');

var DEST = './public';

gulp.task('scripts', function() {
    return gulp.src('./resources/assets/js/*.js')
      .pipe(concat('Complete.js'))
      .pipe(gulp.dest(DEST + '/js'))
      .pipe(rename({suffix: '.min'}))
      .pipe(uglify())
      .pipe(gulp.dest(DEST + '/js'));
});

// Default Task
gulp.task('default', ['scripts']);