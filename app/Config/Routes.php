<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//Home
$routes->add('/home', 'Home::index');
$routes->add('/', 'Home::index');


//Language
$routes->add('/language/switch', 'Language::switch');

//Categories
$routes->add('/category/(:any)', 'Categories::view/$1');

//Registration
$routes->add('/login', 'Registration::index');
$routes->add('/register', 'Registration::registerNewUser');
$routes->add('/logout', 'Registration::logout');

//Products
$routes->add('/products/view_product/(:any)', 'Products::view/$1');

//Rating
$routes->add('/rate/product', 'Products::rate');

//Cart
$routes->add('/cart/add-to-cart', 'Cart::add');
$routes->add('/cart/view-cart', 'Cart::index');
$routes->add('/cart/remove-cart-item', 'Cart::removeCartItem');
$routes->add('/decrease-quantity', 'Cart::decreaseQuantity');
$routes->add('/increase-quantity', 'Cart::increaseQuantity');