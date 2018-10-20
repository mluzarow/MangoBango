module.exports = function (grunt) {
	grunt.initConfig ({
		csslint: {
			files: ['*/*.css']
		}
	});
	
	grunt.loadNpmTasks ("grunt-contrib-csslint");
}
