module.exports = function (grunt) {
	grunt.initConfig ({
		csslint: {
			files: ['app/ViewItems/CSS/*.css']
		}
	});
	
	grunt.loadNpmTasks ("grunt-contrib-csslint");
}
