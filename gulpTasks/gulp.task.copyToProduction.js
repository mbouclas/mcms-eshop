module.exports = (function (gulp,config,$) {
    'use strict';

    return function (){

        $.log('Copying minified files to production');
        return gulp
            .src(config.optimizedDirJs)
            .pipe(gulp.dest(config.publicDirJs));
    }


});
