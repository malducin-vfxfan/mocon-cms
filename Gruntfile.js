module.exports = function(grunt) {
  "use strict";

  // Force use of Unix newlines
  grunt.util.linefeed = '\n';

  // Project configuration.
  grunt.initConfig({

    // Task configuration.
    less: {
      compileSkin: {
        files: {
          'frontend/build/css/skin.css': 'frontend/src/css/bootstrap/less/skin/skin.less'
        }
      }
    },

    csslint: {
      options: {
        'compatible-vendor-prefixes': false,
        'ids': false
      },
      checkSkin: {
        src: ['frontend/build/css/skin.css']
      }
    },

    cssmin: {
      compressSkin: {
        files : {
          'frontend/build/css/skin.min.css' : ['frontend/build/css/skin.css']
        }
      }
    },

    jshint: {
      options: {
        smarttabs: true
      },
      all: ['Gruntfile.js', 'frontend/src/js/*.js'],
      project: ['frontend/src/js/*.js']
    },

    uglify: {
      options: {
        mangle: false
      },
      projectJs: {
        files: {
          'frontend/build/js/admin.min.js': ['frontend/src/js/admin.js'],
          'frontend/build/js/project.min.js': ['frontend/src/js/project.js'],
       }
      }
    },

    concat: {
      projectCssMin: {
        src: ['frontend/src/css/bootstrap/css/bootstrap.min.css', 'frontend/build/css/skin.min.css'],
        dest: 'frontend/build/css/project.min.css'
      },
      projectCss: {
        src: ['frontend/src/css/bootstrap/css/bootstrap.css', 'frontend/build/css/skin.css'],
        dest: 'frontend/build/css/project.css'
      }

    },

    copy: {
      projectCss: {
        files: [
          {
            expand: true,
            cwd: 'frontend/build/css/',
            src: '**/*.css',
            dest: 'cms/webroot/css/',
            flatten: true,
          },
        ]
      },
      projectJs: {
        files: [
          {
            expand: true,
            cwd: 'frontend/build/js/',
            src: '**/*.js',
            dest: 'cms/webroot/js/',
            flatten: true,
          },
        ]
      }
    },

    watch: {
      less: {
        files: 'frontend/src/css/bootstrap/less/skin/*.less',
        tasks: ['less:compileSkin']
      },
      jshint: {
        files: 'frontend/src/js/*.js',
        tasks: ['jshint:project']
      }
    },

    clean: {
      apiDocs: ['docs/manual-api/**']
    },

    shell: {
      apiDocs: {
        options: {
          stdout: true,
          execOptions: {
            cwd: 'C:/work/wamp/apigen'
          }
        },
        command: 'php apigen.php --source C:/work/projects/vfxfan-cms/cms --destination C:/work/projects/vfxfan-cms/docs/manual-api --extensions "php,ctp" --title "VFXfan CMS API Documentation" --access-levels "public,protected,private"'
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-csslint');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-shell');
  grunt.loadNpmTasks('grunt-contrib-clean');

  // CSS task.
  grunt.registerTask('dist-css', ['less:compileSkin', 'csslint:checkSkin', 'cssmin:compressSkin', 'concat:projectCssMin', 'concat:projectCss', 'copy:projectCss']);

  // Javascript task.
  grunt.registerTask('dist-js', ['jshint', 'uglify:projectJs', 'copy:projectJs']);

  // Documentation tasks.
  grunt.registerTask('dist-docs', ['clean:apiDocs', 'shell:apiDocs']);

  // Default task.
  grunt.registerTask('default', ['dist-css']);
};
