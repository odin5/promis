
module.exports = ({ file, options, env }) => ({
    plugins: {
        // include whatever plugins you want
        // but make sure you install these via yarn or npm!

        // add browserslist config to package.json (see below)
        autoprefixer: env === 'production' ? options.autoprefixer : false,
        cssnano: env === 'production' ? options.cssnano : false
    }
});