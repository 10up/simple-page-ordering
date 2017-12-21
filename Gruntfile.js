module.exports = function(grunt) {

	grunt.initConfig({

		makepot: {
			target: {
				options: {
					domainPath: 'localization/',
					mainFile: 'simple-page-ordering.php',
					type: 'wp-plugin',
					updateTimestamp: false
				}
			}
		},

		sass: {
			dist: {
				options: {
					precision: 2,
					sourceMap: true
				},
				files: {
					'assets/css/simple-page-ordering.css': 'assets/css/scss/simple-page-ordering.scss'
				}
			}
		},

		uglify: {
			js: {
				files: {
					'assets/js/simple-page-ordering.min.js': ['assets/js/src/simple-page-ordering.js']
				}
			}
		},

		watch: {
			files: [
				'assets/js/src/*',
				'assets/css/scss/*'
			],
			tasks: ['uglify:js']
		}

	});

	grunt.loadNpmTasks( 'grunt-sass' );
	grunt.loadNpmTasks( 'grunt-autoprefixer' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );

	grunt.registerTask( 'i18n', ['makepot'] );
	grunt.registerTask( 'default', [ 'sass','uglify:js'] );
};
