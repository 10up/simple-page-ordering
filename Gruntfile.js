module.exports = function(grunt) {

	grunt.initConfig({

		makepot: {
			target: {
				options: {
					domainPath: 'localization/',
					mainFile: 'simple-page-ordering.php',
					type: 'wp-plugin',
					updateTimestamp: false,
					updatePoFiles: true
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
				'assets/js/src/*'
			],
			tasks: ['uglify:js']
		}

	});

	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );

	grunt.registerTask( 'i18n', ['makepot'] );
	grunt.registerTask( 'default', ['uglify:js'] );
};