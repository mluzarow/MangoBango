module.exports = function (grunt) {
	grunt.initConfig ({
		csslint: {
			files: ['css/*.css']
		}
	});
	
	grunt.loadNpmTasks ("grunt-contrib-csslint");
}
