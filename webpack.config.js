const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
	Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
	.setOutputPath('public/build/')
	.setPublicPath('/build')
	.addEntry('app', './assets/app.js')
	.addEntry('theme-switcher', './assets/js/theme-switcher.js')
	.splitEntryChunks()
	.enableStimulusBridge('./assets/controllers.json')

	// will require an extra script tag for runtime.js
	// but, you probably want this, unless you're building a single-page app
	.enableSingleRuntimeChunk()
	.configureDevServerOptions(options => {
		options.allowedHosts = [
			'www.tchooz.com',
			'.tchooz.com',
			'localhost',
			'.localhost',
			'www.tchooz.com:8000'
		];
		options.port = 8000;
		options.hot = true;
		// options.inline = true;
		options.proxy = [
			{
				context: ['/build'],
				target: 'https://www.tchooz.com:8000',
				second: false,
			},
		];
		options.headers = {
			"Access-Control-Allow-Origin": "*",
		};
	})

	/*
	 * FEATURE CONFIG
	 *
	 * Enable & configure other features below. For a full
	 * list of features, see:
	 * https://symfony.com/doc/current/frontend.html#adding-more-features
	 */
	.cleanupOutputBeforeBuild()
	.enableBuildNotifications()
	.enableSourceMaps(!Encore.isProduction())
	// enables hashed filenames (e.g. app.abc123.css)
	.enableVersioning(Encore.isProduction())

	// configure Babel
	// .configureBabel((config) => {
	//     config.plugins.push('@babel/plugin-transform-runtime');
	// })

	// enables and configure @babel/preset-env polyfills
	.configureBabelPresetEnv((config) => {
		config.useBuiltIns = 'usage';
		config.corejs = '3.23';
	})

	// enables Sass/SCSS support
	.enableSassLoader()

	// uncomment if you use TypeScript
	//.enableTypeScriptLoader()

	// uncomment if you use React
	// .enableReactPreset()

	.copyFiles({
		from: './assets/styles/images',
		to: 'images/[path][name].[hash:8].[ext]',
		pattern: /\.(ico|png|jpg|jpeg|svg)$/
	})

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
//.enableIntegrityHashes(Encore.isProduction())

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
