<?php namespace	Neyko\Admin;

	use Illuminate\Support\ServiceProvider;
	use Illuminate\Routing\Router;

	class AdminServiceProvider extends ServiceProvider{

		protected $defer = false;
		public function boot(){
			$this->loadViewsFrom(realpath(__DIR__.'/../views'), 'admin');

			$this->publishes([
			    __DIR__.'/../public' => public_path('neyko/admin'),
			], 'public');

			$this->setupRoutes($this->app->router);

			$this->publishes([
				__DIR__.'/config/admin.php' => config_path('admin/admin.php'),
			]);

			$this->loadTranslationsFrom(__DIR__.'/lang', 'admin');
		}
		
		public function setupRoutes(Router $router)
		{
			$router->group(['namespace' => 'Neyko\Admin\Http\Controllers'], function($router)
			{
				require __DIR__.'/Http/routes.php';
			});
		}
		public function register()
		{
			$this->registerAdmin();
			config([
				'config/admin.php',
			]);
		}
		private function registerAdmin()
		{
			$this->app->bind('admin',function($app){
				return new Admin($app);
			});
		}
	}