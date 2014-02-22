module.exports = function(grunt) {

	'use strict';

	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	grunt.initConfig({
		makepot: {
			plugin: {
				options: {
					type: 'wp-plugin',
					domainPath: '/languages',
					mainFile: 'halt.php',
					potFilename: 'halt.pot'
				}
			}
		},

		copy: {
			main: {
				src: [
					'**',
					'!.*',
					'!.*/**',
					'!Gruntfile.js',
					'!package.json',
					'!node_modules/**'
				],
				dest: 'dest/',
				expand: true
			}
		}
	});

};
