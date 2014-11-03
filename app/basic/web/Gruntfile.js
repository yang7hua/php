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
					{dest : 'css/themes/green.css', src: ['less/themes/green.less']},
					{dest : 'css/themes/sky.css', src: ['less/themes/sky.less']},
					{dest : 'css/themes/sunflower.css', src: ['less/themes/sunflower.less']},
					{dest : 'css/themes/red.css', src: ['less/themes/red.less']},
					{dest : 'css/themes/purple.css', src: ['less/themes/purple.less']},
					{dest : 'css/themes/amethyst.css', src: ['less/themes/amethyst.less']},
					{dest : 'css/themes/river.css', src: ['less/themes/river.less']},
					{dest : 'css/themes/pumpkin.css', src: ['less/themes/pumpkin.less']},
					{dest : 'css/themes/black.css', src: ['less/themes/black.less']},
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
