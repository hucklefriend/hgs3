
var gulp        = require('gulp');
var sass        = require('gulp-sass')(require('sass'));
var minifyCSS   = require('gulp-clean-css');
var concat      = require('gulp-concat');
var sourcemaps  = require('gulp-sourcemaps');
var livereload  = require('gulp-livereload');
var connect     = require('gulp-connect');
var download    = require('gulp-download2');
var header      = require('gulp-header');
var uglify      = require('gulp-uglify-es').default;
var merge       = require('merge-stream');
var fileinclude = require('gulp-file-include');
var distPath    = '../../public';

// 01. font-fontawesome
gulp.task('font-fontawesome', function() {
	return gulp.src(['node_modules/@fortawesome/fontawesome-free/webfonts/*'])
		.pipe(gulp.dest(distPath + '/admin/webfonts/'));
});

// 02. font-bootstrap
gulp.task('font-bootstrap', function() {
	return gulp.src(['node_modules/bootstrap-icons/font/fonts/*'])
  	.pipe(gulp.dest(distPath + '/admin/css/fonts/'));
});

// 04. js-theme
gulp.task('js-theme', function(){
	return gulp.src([ 'js/demo/**' ])
		.pipe(gulp.dest(distPath + '/admin/js/theme'));
});

// 05. js-vendor
gulp.task('js-vendor', function(){
  return gulp.src([
  	'node_modules/pace-js/pace.min.js',
  	'node_modules/jquery/dist/jquery.min.js',
  	'node_modules/jquery-ui-dist/jquery-ui.min.js',
  	'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
  	'node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js',
  	'node_modules/js-cookie/src/js.cookie.js'
		])
		.pipe(sourcemaps.init())
		.pipe(concat('vendor.min.js'))
		.pipe(sourcemaps.write())
		.pipe(uglify())
		.pipe(gulp.dest(distPath + '/admin/js/'))
		.pipe(livereload());
});

// 06. js-app
gulp.task('js-app', function(){
  return gulp.src([
  	'js/app.js',
  	])
    .pipe(sourcemaps.init())
    .pipe(concat('app.min.js'))
    .pipe(sourcemaps.write())
    .pipe(uglify())
    .pipe(gulp.dest(distPath + '/admin/js/'))
    .pipe(livereload());
});

// 07. plugins
gulp.task('plugins', function() {
	var pluginFiles = [
  	'node_modules/@fortawesome/*',
  	'node_modules/perfect-scrollbar/*',
  	'node_modules/animate.css/*',
  	'node_modules/pace-js/*',
  	'node_modules/jquery/dist/*',
  	'node_modules/jquery-ui-dist/*',
  	'node_modules/bootstrap/dist/js/*',
  	'node_modules/bootstrap-icons/**',
  	'node_modules/js-cookie/src/*',
		'node_modules/apexcharts/dist/**',
		'node_modules/lity/dist/**',
		'node_modules/x-editable-bs4/dist/**',
		'node_modules/dropzone/dist/**',
  	'node_modules/@fullcalendar/**',
		'node_modules/chart.js/dist/**',
		'node_modules/raphael/raphael.min.js',
		'node_modules/tag-it/css/**',
		'node_modules/tag-it/js/**',
		'node_modules/jquery-migrate/dist/**',
		'node_modules/jquery-mockjax/dist/**',
		'node_modules/x-editable-bs4/dist/**',
		'node_modules/blueimp-file-upload/**',
		'node_modules/blueimp-canvas-to-blob/**',
		'node_modules/blueimp-gallery/**',
		'node_modules/blueimp-load-image/**',
		'node_modules/blueimp-tmpl/**',
		'node_modules/abpetkov-powerange/dist/**',
		'node_modules/bootstrap3-wysihtml5-bower/dist/**',
		'node_modules/summernote/dist/**',
		'node_modules/parsleyjs/dist/**',
		'node_modules/flot/**',
		'node_modules/ckeditor/**',
		'node_modules/jvectormap-next/jquery-jvectormap.css',
		'node_modules/jvectormap-next/jquery-jvectormap.min.js',
		'node_modules/moment/**',
		'node_modules/d3/d3.min.js',
		'node_modules/nvd3/build/**',
		'node_modules/simple-line-icons/css/**',
		'node_modules/simple-line-icons/fonts/**',
		'node_modules/jquery-knob/dist/**',
		'node_modules/sweetalert/dist/**',
		'node_modules/clipboard/dist/**',
		'node_modules/jstree/dist/**',
		'node_modules/gritter/css/**',
		'node_modules/gritter/images/**',
		'node_modules/gritter/js/**',
		'node_modules/datatables.net/js/**',
		'node_modules/datatables.net-bs4/css/**',
		'node_modules/datatables.net-bs4/js/**',
		'node_modules/datatables.net-responsive/js/**',
		'node_modules/datatables.net-responsive-bs4/css/**',
		'node_modules/datatables.net-responsive-bs4/js/**',
		'node_modules/datatables.net-autofill/js/**',
		'node_modules/datatables.net-autofill-bs4/css/**',
		'node_modules/datatables.net-autofill-bs4/js/**',
		'node_modules/datatables.net-buttons/js/**',
		'node_modules/datatables.net-buttons-bs4/css/**',
		'node_modules/datatables.net-buttons-bs4/js/**',
		'node_modules/datatables.net-colreorder/js/**',
		'node_modules/datatables.net-colreorder-bs4/css/**',
		'node_modules/datatables.net-colreorder-bs4/js/**',
		'node_modules/datatables.net-fixedcolumns/js/**',
		'node_modules/datatables.net-fixedcolumns-bs4/css/**',
		'node_modules/datatables.net-fixedcolumns-bs4/js/**',
		'node_modules/datatables.net-fixedheader/js/**',
		'node_modules/datatables.net-fixedheader-bs4/css/**',
		'node_modules/datatables.net-fixedheader-bs4/js/**',
		'node_modules/datatables.net-keytable/js/**',
		'node_modules/datatables.net-keytable-bs4/css/**',
		'node_modules/datatables.net-keytable-bs4/js/**',
		'node_modules/datatables.net-rowreorder/js/**',
		'node_modules/datatables.net-rowreorder-bs4/css/**',
		'node_modules/datatables.net-rowreorder-bs4/js/**',
		'node_modules/datatables.net-scroller/js/**',
		'node_modules/datatables.net-scroller-bs4/css/**',
		'node_modules/datatables.net-scroller-bs4/js/**',
		'node_modules/datatables.net-select/js/**',
		'node_modules/datatables.net-select-bs4/css/**',
		'node_modules/datatables.net-select-bs4/js/**',
		'node_modules/pdfmake/build/**',
		'node_modules/jszip/dist/**',
		'node_modules/bootstrap-datepicker/dist/**',
		'node_modules/bootstrap-timepicker/css/**',
		'node_modules/bootstrap-timepicker/js/**',
		'node_modules/isotope-layout/dist/**',
		'node_modules/lightbox2/dist/**',
		'node_modules/bootstrap-datetime-picker/css/**',
		'node_modules/bootstrap-datetime-picker/js/**',
		'node_modules/masonry-layout/dist/**',
		'node_modules/select2/dist/**',
		'node_modules/select-picker/dist/**',
		'node_modules/jvectormap-next/**',
		'node_modules/spectrum-colorpicker2/dist/*',
		'node_modules/jquery.maskedinput/src/**',
		'node_modules/ion-rangeslider/css/**',
		'node_modules/ion-rangeslider/js/**',
		'node_modules/bootstrap-daterangepicker/daterangepicker.css',
		'node_modules/bootstrap-daterangepicker/daterangepicker.js',
		'node_modules/flag-icon-css/css/**',
		'node_modules/flag-icon-css/flags/**',
		'node_modules/jquery-sparkline/jquery.sparkline.min.js',
		'node_modules/bootstrap-social/bootstrap-social.css',
		'node_modules/intro.js/minified/**',
		'node_modules/angular/**',
		'node_modules/angular-ui-router/release/**',
		'node_modules/angular-ui-bootstrap/dist/**',
		'node_modules/oclazyload/dist/**',
		'node_modules/swiper/*',
		'node_modules/switchery/dist/*',
		'node_modules/lightbox2/dist/**',
		'node_modules/@highlightjs/**'
	];
	
	download([
		'https://raw.githubusercontent.com/kbwood/countdown/master/dist/js/jquery.plugin.min.js',
		'https://raw.githubusercontent.com/kbwood/countdown/master/dist/js/jquery.countdown.min.js',
		'https://raw.githubusercontent.com/kbwood/countdown/master/dist/css/jquery.countdown.css'
	]).pipe(gulp.dest(distPath + '/admin/plugins/countdown/'));
	download([
		'https://raw.githubusercontent.com/seyDoggy/superbox/master/js/jquery.superbox.min.js',
		'https://raw.githubusercontent.com/seyDoggy/superbox/master/css/superbox.min.css'
	]).pipe(gulp.dest(distPath + '/admin/plugins/superbox/'));
	download([
		'https://raw.githubusercontent.com/seyDoggy/superbox/master/css/font/superboxicons.eot',
		'https://raw.githubusercontent.com/seyDoggy/superbox/master/css/font/superboxicons.svg',
		'https://raw.githubusercontent.com/seyDoggy/superbox/master/css/font/superboxicons.ttf',
		'https://raw.githubusercontent.com/seyDoggy/superbox/master/css/font/superboxicons.woff'
	]).pipe(gulp.dest(distPath + '/admin/plugins/superbox/font/'));
	download([
		'https://unpkg.com/ionicons@4.2.6/dist/css/ionicons.min.css'
	]).pipe(gulp.dest(distPath + '/admin/plugins/ionicons/css/'));
	download([
		'https://unpkg.com/ionicons@4.2.6/dist/fonts/ionicons.eot',
		'https://unpkg.com/ionicons@4.2.6/dist/fonts/ionicons.woff2',
		'https://unpkg.com/ionicons@4.2.6/dist/fonts/ionicons.woff',
		'https://unpkg.com/ionicons@4.2.6/dist/fonts/ionicons.ttf',
		'https://unpkg.com/ionicons@4.2.6/dist/fonts/ionicons.svg'
	]).pipe(gulp.dest(distPath + '/admin/plugins/ionicons/fonts'));
	download([
		'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-calendar/0.2.5/css/calendar.min.css'
	]).pipe(gulp.dest(distPath + '/admin/plugins/bootstrap-calendar/css/'));
	download([
		'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-calendar/0.2.5/js/calendar.min.js'
	]).pipe(gulp.dest(distPath + '/admin/plugins/bootstrap-calendar/js/'));
	download([
		'https://jvectormap.com/js/jquery-jvectormap-world-mill.js'
	]).pipe(gulp.dest(distPath + '/admin/plugins/jvectormap-next/'));
	
	return gulp.src(pluginFiles, { base: './node_modules/' })
		.pipe(gulp.dest(distPath + '/admin/plugins'));
});


// 08. css-vendor
gulp.task('css-vendor', function(){
  return gulp.src([
		'node_modules/animate.css/animate.min.css',
		'node_modules/@fortawesome/fontawesome-free/css/all.min.css',
		'node_modules/jquery-ui-dist/jquery-ui.min.css',
		'node_modules/pace-js/themes/black/pace-theme-flash.css',
		'node_modules/perfect-scrollbar/css/perfect-scrollbar.css'
		])
		.pipe(concat('vendor.min.css'))
		.pipe(minifyCSS({debug: false}, (details) => {
      console.log(`${details.name}: ${details.stats.originalSize}`);
      console.log(`${details.name}: ${details.stats.minifiedSize}`);
    }))
		.pipe(gulp.dest(distPath + '/admin/css/'))
		.pipe(livereload());
});

// 44. css-transparent
gulp.task('css-transparent', function(){
  return gulp.src([
			'scss/transparent/styles.scss'
		])
		.pipe(sass())
		.pipe(concat('app.min.css'))
	    .pipe(minifyCSS())
		.pipe(gulp.dest(distPath + '/admin/css/'))
		.pipe(livereload());
});


// 46. css-transparent-theme
gulp.task('css-transparent-theme', function(){
	var colorList = ['red','pink','orange','yellow','lime','green','teal','cyan','blue','purple','indigo','black'];
	
	var tasks = colorList.map(function (color) {
		return gulp.src([ 'scss/transparent/theme.scss' ])
			.pipe(header('$primary-color: \''+ color +'\';'))
			.pipe(sass())
			.pipe(concat(color +'.min.css'))
			.pipe(minifyCSS())
			.pipe(gulp.dest(distPath + '/admin/css/theme/'));
  });
	console.log('Generating the css files. Please wait...');
  return merge(tasks);
});

// 47. css-transparent-image
gulp.task('css-transparent-image', function(){
	return gulp.src([ 'scss/transparent/images/**' ])
		.pipe(gulp.dest(distPath + '/admin/css/images'));
});


// 51. transparent
gulp.task('transparent', gulp.series(gulp.parallel([
	'font-fontawesome',
	'font-bootstrap',
	'js-vendor', 
	'js-app',
	'plugins',
	'css-vendor', 
	'css-transparent',
	'css-transparent-theme',
	'css-transparent-image'
])));


