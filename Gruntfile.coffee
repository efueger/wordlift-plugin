module.exports = (grunt) ->

  # Project configuration.
  grunt.initConfig
    pkg: grunt.file.readJSON('package.json')

    coffee:
      compile:
        options:
          join: true
        files:
          'src/js/wordlift-tinymce-plugin.js': ['src/coffee/wordlift-tinymce-plugin.coffee']

    less:
      development:
        files:
          'src/css/wordlift-admin.css': ['src/less/wordlift-admin.less']

    watch:
      scripts:
        files: ['src/coffee/*.coffee']
        tasks: ['coffee']
        options:
          spawn: false
      styles:
        files: ['src/less/*.less']
        tasks: ['less']
        options:
          spawn: false,

  # Load plugins
  grunt.loadNpmTasks('grunt-contrib-watch')
  grunt.loadNpmTasks('grunt-contrib-coffee')
  grunt.loadNpmTasks('grunt-contrib-less')

  # Default task(s).
  grunt.registerTask('default', ['coffee'])