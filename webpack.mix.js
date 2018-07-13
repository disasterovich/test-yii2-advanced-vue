//const { mix } = require('laravel-mix');
const { env } = require('minimist')(process.argv.slice(2));

//console.log(env);

if (env && env.site) {
    require(`${__dirname}/webpack_${env.site}.mix.js`);
}