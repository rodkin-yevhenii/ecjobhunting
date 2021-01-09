const gulp = require( 'gulp' ),
  pug = require( 'gulp-pug' ),
  browsersync = require( 'browser-sync' ),
  concat = require( 'gulp-concat' ),
  uglify = require( 'gulp-uglify' ),
  babel = require( 'gulp-babel' ),
  rename = require( 'gulp-rename' ),
  del = require( 'del' ),
  sass = require( 'gulp-sass' ),
  plumber = require( "gulp-plumber" ),
  notify = require( "gulp-notify" ),
  autoprefixer = require( 'gulp-autoprefixer' ),
  sourcemaps = require( 'gulp-sourcemaps' ),
  gulpif = require( 'gulp-if' ),
  argv = require( 'yargs' ).argv,
  cleanCSS = require( 'gulp-clean-css' );

gulp.task( 'markup', function () {
  return gulp.src( 'src/pug/pages/*.pug' )
    .pipe( plumber() )
    .pipe( pug( {
      pretty: true
    } ) )
    .on( "error", notify.onError( function ( error ) {
      return "Something happened: " + error.message;
    } ) )
    .pipe( gulp.dest( 'public' ) )
    .pipe( gulpif( argv.dev, browsersync.reload( {
      stream: true
    } ) ) );
} );

/** styles */

gulp.task( 'styles', function () {
  return gulp.src( 'src/scss/main.scss' )
    .pipe( rename( "styles.min.scss" ) )
    .pipe( plumber() )
    .pipe( gulpif( argv.dev, sourcemaps.init() ) )
    .pipe( sass() )
    .on( "error", notify.onError( function ( error ) {
      return "Something happened: " + error.message;
    } ) )
    .pipe( autoprefixer( [ 'last 2 version' ] ) )
    .pipe( cleanCSS() )
    .pipe( gulpif( argv.dev, sourcemaps.write() ) )
    .pipe( gulp.dest( 'public/css' ) )
    .pipe( gulpif( argv.dev, browsersync.reload( {
      stream: true
    } ) ) );
} );

/** scripts */

gulp.task( 'scripts', function () {
  const scripts = {
    'index': [
      'src/js/general.js'
    ]
  };
  Object.keys( scripts ).forEach( name => {
    gulp.src( scripts[name] )
      .pipe( babel( {
        presets: [ '@babel/env' ]
      } ) )
      .pipe( concat( 'scripts.js' ) )
      .pipe( gulpif( argv.prod, uglify() ) )
      .pipe( gulp.dest( `public/js/${ name }` ) )
      .pipe( gulpif( argv.dev, browsersync.reload( {
        stream: true
      } ) ) );
  } );
} );

gulp.task( 'libs', function () {
  const libs = {
    'index': [
      'node_modules/jquery/dist/jquery.min.js',
      'node_modules/bootstrap/dist/js/bootstrap.min.js',
      'node_modules/scroll-lock/dist/scroll-lock.min.js',
      'node_modules/slick-carousel/slick/slick.min.js',
      'node_modules/nouislider/distribute/nouislider.min.js'
    ]
  };
  Object.keys( libs ).forEach( name => {
    gulp.src( libs[name] )
      .pipe( concat( 'libs.js' ) )
      .pipe( gulp.dest( `public/js/${ name }` ) )
  } );
} );

/*** */

gulp.task( 'repaint', (done) => {
  browsersync( {
    server: {
      baseDir: 'public',
      directory: true
    }
  } );
  done();
} );

gulp.task( 'clean', function () {
  return del.sync( [ 'public/js', 'public/css', 'public/*.html' ] );
} );

gulp.task( 'watch', (done) => {
  gulp.watch( 'src/pug/**/*.pug', [ 'markup' ] );
  gulp.watch( 'src/scss/**/*.scss', [ 'styles' ] );
  gulp.watch( [ 'src/js/**/*.js' ], [ 'scripts' ] );
  done();
} );

gulp.task( 'build', (done) =>{
  gulp.series('clean', gulp.parallel( 'markup', 'styles', 'libs', 'scripts' ) )(done)
});
gulp.task( 'default', (done) =>{
  gulp.series('watch' )(done)
} );
