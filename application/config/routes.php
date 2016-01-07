<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "market";
$route['404_override'] = '';

$route['shop'] = 'shop';
$route['shop/(:any)'] = 'shop/$1';

/*Кишочки*/

$route['auth'] = 'auth';
$route['auth/(:any)'] = 'auth/$1';
$route['admin'] = 'admin';
$route['admin/(:any)'] = 'admin/$1';
$route['upload'] = 'upload';
$route['upload/(:any)'] = 'upload/$1';

/*Морда*/
$route['(:any)'] = 'market/index/$1';

$route['about'] = 'market/about';
$route['about/(:any)'] = 'market/about';

$route['sitemap'] = 'market/sitemap';
$route['sitemap/(:any)'] = 'market/sitemap';

$route['contact'] = 'market/contact';
$route['contact/(:any)'] = 'market/contact';

$route['product'] = 'market';
$route['pid(:any)'] = 'market/product/$1';

$route['qw'] = 'market';
$route['qw(:any)'] = 'market/quick_view/$1';

$route['sauce'] = 'market/sauce';
$route['sid(:any)'] = 'market/sauce/$1';

$route['cart'] = 'market/cart';
$route['cart_overview'] = 'market/cart_overview';
$route['cartview/(:any)'] = 'market/cartview/$1';
$route['checkout'] = 'market/checkout';

/* End of file routes.php */
/* Location: ./application/config/routes.php */