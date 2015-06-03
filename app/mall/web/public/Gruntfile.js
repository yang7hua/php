module.exports = function(grunt){
	grunt.initConfig({
		less : {
			options : {
				paths : ['less'],
				compress : true,
				yuicompress : true
			},
			//编译	
			css : {
				options : {
					paths : ['less']
				},
				files : [
					{dest : 'css/base.css', src: ['less/base.less']},
					{dest : 'css/site.css', src: ['less/site.less']},
					{dest : 'css/adm.css', src: ['less/adm.less']},
				]
			}
		},
		watch : {
			css : {
				files : ['less/*.less', 'less/themes/*.less'],
				tasks : ['less']
			}
		}
	});
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.registerTask('default', ['less', 'watch']);
}
