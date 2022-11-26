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



Route::prefix('/admin')->namespace('Admin')->group(function(){
    //all the admin route we are going to add here :-
    Route::match(['get','post'],'/','AdminController@login')->name('admin');

    Route::group(['middleware'=>['admin']],function(){
        Route::get('dashboard','AdminController@dashboard');
        Route::get('settings','AdminController@settings');
        Route::get('logout','AdminController@logout');
        Route::post('check-current-pwd','AdminController@chkCurrentPassword');
        Route::post('update-current-pwd','AdminController@updateCurrentPassword');
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');

        // Sections
        Route::get('sections', 'SectionController@sections')->name('sections');
        Route::post('update-section-status','SectionController@updateSectionStatus')->name('update.section.status');

        // brands
        Route::get('brands', 'BrandController@Brands')->name('brands');
        Route::post('update-brand-status','BrandController@updateBrandStatus')->name('update.brand.status');
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand')->name('add.edit.brand');
        Route::get('delete-brand/{id?}', 'BrandController@deleteBrand')->name('delete.brand');

        // Categories
        Route::get('categories', 'CategoryController@categories')->name('categories');
        Route::post('update-category-status','CategoryController@updateCategoryStatus')->name('update.category.status');
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory')->name('add.edit.category');

        Route::post('append-categories-level','CategoryController@appendCategoryLevel');
        Route::get('delete-category-image/{id?}', 'CategoryController@deleteCategoryImage')->name('delete.category.image');
        Route::get('delete-category/{id?}', 'CategoryController@deleteCategory')->name('delete.category');

        // Products 
        Route::get('products', 'ProductsController@products')->name('products');
        Route::post('update-product-status','ProductsController@updateProductStatus')->name('update.product.status');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductsController@addEditProduct')->name('add.edit.product');

        Route::get('delete-product/{id?}', 'ProductsController@deleteProduct')->name('delete.product');
        Route::get('delete-product-image/{id?}', 'ProductsController@deleteProductImage')->name('delete.product.image');
        Route::get('delete-product-video/{id?}', 'ProductsController@deleteProductVideo')->name('delete.product.video');

        //Product Attributes
        Route::match(['get', 'post'], 'add-attributes/{id?}','ProductsController@addAttributes')->name('add.attributes');
        Route::match(['get', 'post'], 'edit-attributes/{id?}','ProductsController@editAttributes')->name('edit.attributes');
        Route::post('update-attribute-status','ProductsController@updateAttributeStatus')->name('update.attribute.status');
        Route::get('add-attributes/delete-attribute/{id?}', 'ProductsController@deleteAttribute')->name('delete.attribute');
        
        //Images
        Route::match(['get', 'post'], 'add-images/{id?}','ProductsController@addImages')->name('add.images');
        Route::post('update-image-status','ProductsController@updateImageStatus')->name('update.image.status');
        Route::get('add-images/delete-image/{id?}', 'ProductsController@deleteImage')->name('delete.images');

        //Banners
        Route::get('banners','BannersController@banners')->name('banners');
        Route::post('update-banner-status','BannersController@updateBannerStatus')->name('update.banner.status');
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', 'BannersController@addEditBanner')->name('add.edit.banner');
        Route::get('delete-banner/{id?}', 'BannersController@deleteBanner')->name('delete.banner');
    });

});


 //All the Front route we are going to add here :-

use App\Category;
Auth::routes();

Route::namespace('Front')->group(function(){
    //Home Page Route
    Route::get('/','IndexController@index')->name('home');

    //Listing /Categories Routes
    // Route::get('/{url}','ProductsController@listing')->name('listing');

    //Get Category Url's
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    foreach ($catUrls as $url)
    {
    Route::get('/'.$url,'ProductsController@listing')->name('listing');
    }

    //Product Detail Route
    Route::get('/product/{id}','ProductsController@detail')->name('product.detail');

    //Get Product Attribute Price
    Route::post('/get-product-price','ProductsController@getProductPrice')->name('get.product.price');


});









