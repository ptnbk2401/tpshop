<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('TPShop')->group(function(){
	Route::get('/',[
		'uses'	=> 'IndexController@index',
		'as'	=> 'tpshop.index.index',
	]);
	Route::get('/Lien-he',[
		'uses'	=> 'ContactController@getIndex',
		'as'	=> 'tpshop.contact.index'
	]);
	Route::post('/Lien-he',[
		'uses'	=> 'ContactController@postIndex',
		'as'	=> 'tpshop.contact.index'
	]);
	Route::get('/danhmuc/{slug}_{id}',[
		'uses'	=> 'CatController@index',
		'as'	=> 'tpshop.cat.index'
	]);
	Route::get('/product/{slug}_{id}.html',[
		'uses'	=> 'DetailController@index',
		'as'	=> 'tpshop.detail.index'
	]);

	Route::get('/gio-hang',[
		'uses'	=> 'CartController@index',
		'as'	=> 'tpshop.cart.index'
	]);
	Route::get('/addCart/',[
		'uses'	=> 'CartController@addCart',
		'as'	=> 'tpshop.cart.addcart'
	]);
	Route::get('/changeSluong/',[
		'uses'	=> 'CartController@changeSluong',
		'as'	=> 'tpshop.cart.changesl'
	]);
	Route::get('/delCart/{id}',[
		'uses'	=> 'CartController@delCart',
		'as'	=> 'tpshop.cart.delcart'
	]);
	Route::post('/add',[
		'uses'	=> 'UserController@postAdd',
		'as'	=> 'tpshop.user.add'
	]);
	Route::get('/profile',[
		'uses'	=> 'UserController@profile',
		'as'	=> 'tpshop.user.profile'
	]);
	Route::get('/profile/edit/{id}',[
		'uses'	=> 'UserController@getEdit',
		'as'	=> 'tpshop.user.edit'
	]);
	Route::post('/profile/edit/{id}',[
		'uses'	=> 'UserController@postEdit',
		'as'	=> 'tpshop.user.edit'
	]);
	Route::post('/profile/editpass/{id}',[
		'uses'	=> 'UserController@postEditPass',
		'as'	=> 'tpshop.user.editpass'
	]);
	Route::post('/profile/address/{id}',[
		'uses'	=> 'UserController@postAddress',
		'as'	=> 'tpshop.user.diachi'
	]);
	Route::get('/changeQuan',[
		'uses'	=> 'AjaxController@changeQuan',
		'as'	=> 'tpshop.address.changeQuan'
	]);
	Route::get('/changePhuong',[
		'uses'	=> 'AjaxController@changePhuong',
		'as'	=> 'tpshop.address.changePhuong'
	]);

	Route::get('/thanh-toan',[
		'uses'	=> 'PayController@index',
		'as'	=> 'tpshop.pay.index'
	]);
	Route::get('/don-hang',[
		'uses'	=> 'PayController@finish',
		'as'	=> 'tpshop.pay.finish'
	]);
	Route::get('/hoan-thanh',[
		'uses'	=> 'PayController@finished',
		'as'	=> 'tpshop.pay.finished'
	]);
	Route::get('/getItems',[
		'uses'	=> 'PayController@getItems',
		'as'	=> 'tpshop.pay.getItems'
	]);
	Route::get('/tinhtien',[
		'uses'	=> 'PayController@thongtinThanhToan',
		'as'	=> 'tpshop.pay.tinhtien'
	]);

	Route::get('/checkcode',[
		'uses'	=> 'PayController@checkcode',
		'as'	=> 'tpshop.pay.checkcode'
	]);
	Route::get('/addorder',[
		'uses'	=> 'PayController@addOrder',
		'as'	=> 'tpshop.pay.addorder'
	]);

	Route::get('/paypal',[
		'uses'	=> 'PayController@paypal',
		'as'	=> 'tpshop.pay.paypal'
	]);

});

Route::namespace('Admin')->middleware('auth')->group(function(){	
	Route::prefix('admincp')->middleware('role:admin|nguyenpt')->group(function(){	
		Route::get('/',[
			'uses'	=> 'IndexController@index',
			'as'	=> 'admin.index.index',
		]);
	
		Route::prefix('categories')->group(function(){
			Route::get('/index',[
				'uses'	=> 'CatController@index',
				'as'	=> 'admin.cat.index',
			]);
			Route::get('/add',[
				'uses'	=> 'CatController@getAdd',
				'as'	=> 'admin.cat.add',
			])->middleware('role:admin|nguyenpt');
			Route::post('/add',[
				'uses'	=> 'CatController@postAdd',
				'as'	=> 'admin.cat.add',
			]);

			Route::get('/edit/{id}',[
				'uses'	=> 'CatController@getEdit',
				'as'	=> 'admin.cat.edit',
			])->middleware('role:admin|nguyenpt');
			Route::post('/edit/{id}',[
				'uses'	=> 'CatController@postEdit',
				'as'	=> 'admin.cat.edit',
			]);
			Route::get('/moveTrash/{id}',[
				'uses'	=> 'CatController@moveTrash',
				'as'	=> 'admin.cat.movetrash',
			])->middleware('role:admin|nguyenpt');

			Route::get('/trash',[
				'uses'	=> 'CatController@getTrash',
				'as'	=> 'admin.cat.trash',
			]);
			Route::get('/recycle/{id}',[
				'uses'	=> 'CatController@recycle',
				'as'	=> 'admin.cat.recycle',
			])->middleware('role:admin|nguyenpt');
			Route::get('/delete/{id}',[
				'uses'	=> 'CatController@delete',
				'as'	=> 'admin.cat.del',
			])->middleware('role:admin|nguyenpt');

			Route::get('/allTrash/{luachon}',[
				'uses'	=> 'CatController@allTrash',
				'as'	=> 'admin.cat.alltrash',
			])->middleware('role:admin|nguyenpt');

		});

		Route::prefix('product')->group(function(){
			Route::get('/index',[
				'uses'	=> 'ProductController@index',
				'as'	=> 'admin.product.index',
			]);
			Route::get('/add',[
				'uses'	=> 'ProductController@getAdd',
				'as'	=> 'admin.product.add',
			]);
			Route::post('/add',[
				'uses'	=> 'ProductController@postAdd',
				'as'	=> 'admin.product.add',
			]);

			Route::get('/edit/{id}',[
				'uses'	=> 'ProductController@getEdit',
				'as'	=> 'admin.product.edit',
			]);
			Route::post('/edit/{id}',[
				'uses'	=> 'ProductController@postEdit',
				'as'	=> 'admin.product.edit',
			]);
			Route::get('/moveTrash/{id}',[
				'uses'	=> 'ProductController@moveTrash',
				'as'	=> 'admin.product.movetrash',
			]);

			Route::get('/trash',[
				'uses'	=> 'ProductController@getTrash',
				'as'	=> 'admin.product.trash',
			]);
			Route::get('/recycle/{id}',[
				'uses'	=> 'ProductController@recycle',
				'as'	=> 'admin.product.recycle',
			]);
			Route::get('/delete/{id}',[
				'uses'	=> 'ProductController@delete',
				'as'	=> 'admin.product.del',
			]);

			Route::get('/allTrash/{luachon}',[
				'uses'	=> 'ProductController@allTrash',
				'as'	=> 'admin.product.alltrash',
			]);			

		});

		Route::prefix('order')->middleware('role:admin')->group(function(){
			Route::get('/index',[
				'uses'	=> 'OrderController@index',
				'as'	=> 'admin.order.index',
			]);
			Route::get('/del/{id}',[
				'uses'	=> 'OrderController@delete',
				'as'	=> 'admin.order.delete',
			]);
			
			Route::get('/changeTTDH',[
				'uses'	=> 'OrderController@changeTTDH',
				'as'	=> 'admin.order.changeTTDH',
			]);

		});

		Route::prefix('contact')->group(function(){
			Route::get('/index',[
				'uses'	=> 'ContactController@index',
				'as'	=> 'admin.contact.index'
			]);
			Route::post('/sendmail/{id}',[
				'uses'	=> 'ContactController@sendMail',
				'as'	=> 'admin.contact.sendmail'
			])->middleware('role:admin|nguyenpt');

			Route::get('/delete/{id}',[
				'uses'	=> 'ContactController@delete',
				'as'	=> 'admin.contact.delete'
			])->middleware('role:admin|nguyenpt');
		}); 
		Route::prefix('user')->group(function(){
			Route::get('/index',[
				'uses'	=> 'UserController@index',
				'as'	=> 'admin.user.index'
			]);
			Route::get('/add',[
				'uses'	=> 'UserController@getAdd',
				'as'	=> 'admin.user.add'
			])->middleware('role:1');
			Route::post('/add',[
				'uses'	=> 'UserController@postAdd',
				'as'	=> 'admin.user.add'
			]);

			Route::get('/edit/{id}',[
				'uses'	=> 'UserController@getEdit',
				'as'	=> 'admin.user.edit'
			]);
			Route::post('/edit/{id}',[
				'uses'	=> 'UserController@postEdit',
				'as'	=> 'admin.user.edit'
			]);

			Route::get('/delete/{id}',[
				'uses'	=> 'UserController@delete',
				'as'	=> 'admin.user.delete'
			])->middleware('role:1');

			Route::get('/profile',[
				'uses'	=> 'UserController@profile',
				'as'	=> 'admin.user.profile'
			]);
		}); 

		Route::prefix('code')->group(function(){
			Route::get('/index',[
				'uses'	=> 'CodeController@index',
				'as'	=> 'admin.code.index'
			]);
			Route::get('/add',[
				'uses'	=> 'CodeController@getAdd',
				'as'	=> 'admin.code.add'
			]);
			Route::post('/add',[
				'uses'	=> 'CodeController@postAdd',
				'as'	=> 'admin.code.add'
			]);
			Route::get('/delete/{id}',[
				'uses'	=> 'CodeController@delete',
				'as'	=> 'admin.code.delete'
			]);

			
		}); 
	}); 

});
// Auth::routes();

 // Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Ajax')->prefix('admin')->group(function(){

	Route::get('/ajax/product/hot/',[
		'uses'	=> 'AProductController@CheckedHot',
		'as'	=> 'admin.product.hot',
	]);

	Route::get('/ajax/product/sale/',[
		'uses'	=> 'AProductController@CheckedSale',
		'as'	=> 'admin.product.sale',
	]);
	Route::get('/changeSize',[
		'uses'	=> 'AProductController@changeSize',
		'as'	=> 'admin.product.changeSize',
	]);

	Route::get('/selectColor',[
		'uses'	=> 'AProductController@selectColor',
		'as'	=> 'admin.product.selectColor',
	]);
});


Route::namespace('Auth')->group(function(){

	Route::get('/login',[
		'uses'	=> 'AuthController@getLogin',
		'as'	=> 'auth.login'
	]);
	Route::post('/login',[
		'uses'	=> 'AuthController@postLogin',
		'as'	=> 'auth.login'
	]);
	Route::get('/logout',[
		'uses'	=> 'AuthController@logout',
		'as'	=> 'auth.logout'
	]);
});