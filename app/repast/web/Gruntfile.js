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
					{dest : 'css/site.css', src: ['less/site.less']},
					{dest : 'css/sysadm.css', src: ['less/sysadm.less']},
				]
			}
		},
		watch : {
			css : {
				files : ['less/*.less'],
				tasks : ['less']
			}
		}
	});
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.registerTask('default', ['less', 'watch']);
}
