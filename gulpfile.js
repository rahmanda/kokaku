var gulp = require('gulp');
var gutil = require('gulp-util');
var concat = require('gulp-concat');
var sass = require('gulp-sass');
var minifyCss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var livereload = require('gulp-livereload');

var prefix = {
  app: './app/',
  public: './public/',
  scripts: './public/js/',
  scriptsModules: './app/scripts/modules/'
}

var paths = {
  sass: ['./scss/**/*.scss'],
  scripts: [
  prefix.scripts + "kokaku.utils.js",
  prefix.scripts + "kokaku.navBar.js",
  prefix.scripts + "kokaku.navContent.js",
  prefix.scripts + "kokaku.pagination.js",
  prefix.scripts + "kokaku.metadatas.js",
  prefix.scripts + "kokaku.flash.js",
  prefix.scripts + "kokaku.auth.js",
  prefix.scripts + "kokaku.schemaForm.js",
  prefix.scripts + "kokaku.contentTab.js",
  prefix.scripts + "kokaku.upload.js",
  prefix.scripts + "kokaku.statistic.js",
  prefix.scripts + "kokaku.sideNav.js",
  prefix.scripts + "kokaku.modal.js",
  prefix.scripts + "kokaku.user.js",
  prefix.scripts + "kokaku.sync.js",
  prefix.scripts + "kokaku.preference.js"
  ]
};

var filename = {
  style: 'style',
  script: 'kokaku'
}

var dests = {
  style: prefix.public + 'css/',
  script: prefix.scripts,
} 

gulp.task('default', ['watch']);

gulp.task('sass', function(done) {
  return gulp.src(paths.sass)
    .pipe(sass({
      includePaths: require('node-neat').includePaths
    }))
    .pipe(rename(filename.style + '.css'))
    .pipe(gulp.dest(dests.style))
    .pipe(minifyCss({
      keepSpecialComments: 0
    }))
    .pipe(rename(filename.style + '.min.css'))
    .pipe(gulp.dest(dests.style))
    .pipe(livereload());
});

gulp.task('scripts', function(done) {
  return gulp.src(paths.scripts)
    .pipe(concat(filename.script + '.min.js'))
    .pipe(gulp.dest(dests.script));
});

gulp.task('watch', function() {
  livereload.listen();
  gulp.watch(paths.sass, ['sass']);
  gulp.watch(paths.scripts, ['scripts']);
});