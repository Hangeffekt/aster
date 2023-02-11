<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\GarantieController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MetatagsController;
use App\Http\Controllers\OrderController;
use App\Mail\WelcomeMail;

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

//login
Route::get("/login", [UserAuthController::class, "login"])->middleware("AlreadyLoggedIn");
Route::get("/register", [UserAuthController::class, "register"])->middleware("AlreadyLoggedIn");
Route::post("create", [UserAuthController::class, "create"])->name("auth.create");
Route::post("check", [UserAuthController::class, "check"])->name("auth.check");

Route::get("/admin/profile", [UserAuthController::class, "adminProfile"])->middleware("isLogged");
Route::get("/logout", [UserAuthController::class, "Logout"]);

//main page
Route::get("/", [HeadController::class, "head"]);

//search
Route::post("productsearch", [ProductController::class, "search"])->name("search");

//catalog
Route::get("/catalog/{id?}/{order_nema?}/{order_value_1?}/{order_value_2?}", [CatalogController::class, "show"]);

//product
Route::get("/product/{id?}", [ProductController::class, "show"]);
Route::post("addtocart", [ProductController::class, "addToCart"])->name("shop.addToCart")->middleware("isLogged");

//cart
Route::get("/cart", [CartController::class, "show"])->middleware("isLogged");
Route::post("refreshcart", [CartController::class, "refreshCart"])->name("shop.refreshCart")->middleware("isLogged");
Route::post("deletecart", [CartController::class, "deleteCart"])->name("shop.deleteCart")->middleware("isLogged");

//payment and delivery
Route::get("/delivery", [CartController::class, "delivery"])->middleware("isLogged");
Route::post("finishdelivery", [CartController::class, "finishDelivery"])->name("shop.finishDelivery")->middleware("isLogged");
Route::get("/payment", [CartController::class, "payment"])->middleware("isLogged");
Route::post("finishpayment", [CartController::class, "finishPayment"])->name("shop.finishPayment")->middleware("isLogged");

//checkout
Route::get("/checkout", [CartController::class, "checkout"])->middleware("isLogged");
Route::post("/finishcheckout", [CartController::class, "finishCheckout"])->name("shop.finishCheckout")->middleware("isLogged");

//payment success
Route::get("/thankyou", [CartController::class, "thankyou"])->middleware("isLogged");

//payment faild

//user information
Route::get("/profile", [ProfileController::class, "show"])->middleware("isLogged");
Route::get("/editprofile", [ProfileController::class, "editProfile"])->middleware("isLogged");
Route::post("/editprofile", [ProfileController::class, "modifyProfile"])->name("user.editprofile")->middleware("isLogged");
Route::post("/modifypassword", [ProfileController::class, "modifyPassword"])->name("user.modifypassword")->middleware("isLogged");
Route::get("/address/{addressid?}", [ProfileController::class, "address"])->middleware("isLogged");
Route::get("/invoice/{addressid?}", [ProfileController::class, "invoice"])->middleware("isLogged");
Route::post("adddelivery", [ProfileController::class, "addDelivery"])->name("shop.addDelivery")->middleware("isLogged");
Route::post("modifydelivery", [ProfileController::class, "modifyDelivery"])->name("shop.modifyDelivery")->middleware("isLogged");
Route::post("deletedelivery", [ProfileController::class, "deleteDelivery"])->name("shop.deleteDelivery")->middleware("isLogged");
Route::post("deleteinvoice", [ProfileController::class, "deleteInvoice"])->name("shop.deleteInvoice")->middleware("isLogged");
Route::post("addinvoice", [ProfileController::class, "addInvoice"])->name("shop.addInvoice")->middleware("isLogged");
Route::post("modifyinvoices", [ProfileController::class, "modifyInvoices"])->name("shop.modifyInvoices")->middleware("isLogged");

//orders
Route::get("/order/{id}", [ProfileController::class, "order"])->middleware("isLogged");
Route::get("/orders", [ProfileController::class, "orders"])->middleware("isLogged");

//delete registration

//rout for mailing
Route::get("/email", function() {
    return new WelcomeMail();
});

//admin.login
Route::get("admin/login", [UserAuthController::class, "adminLogin"])->middleware("AdminAlreadyLoggedIn");
Route::get("admin/register", [UserAuthController::class, "adminRegister"])->middleware("AdminAlreadyLoggedIn");
Route::post("admin/create", [UserAuthController::class, "adminCreate"])->name("admin.create");
Route::post("admin/check", [UserAuthController::class, "adminCheck"])->name("admin.check");

Route::get("admin/profile", [UserAuthController::class, "adminProfile"])->middleware("adminIsLogged");
Route::get("admin/logout", [UserAuthController::class, "adminLogout"]);

//orders ans users
Route::get("admin/users", [ProfileController::class, "adminUsers"])->middleware("adminIsLogged");
Route::get("admin/user/{userid?}", [ProfileController::class, "adminUser"])->middleware("adminIsLogged");
Route::post("admin/modifyuser", [ProfileController::class, "modifyProfile"])->name("admin.modifyUser");
Route::post("admin/modifyaddress", [ProfileController::class, "modifyDelivery"])->name("admin.modifyAddress");
Route::post("admin/modifyinvoice", [ProfileController::class, "modifyInvoices"])->name("admin.modifyInvoice");
Route::get("admin/user/addresses/{userid?}/{addressid?}", [ProfileController::class, "address"])->middleware("adminIsLogged");

Route::resource("admin/orders", OrderController::class)->middleware("adminIsLogged");

//main datas
Route::get("main", [HeadController::class, "getMainData"])->middleware("adminIsLogged");

//admin.pages
Route::get("page/{id?}", [PageController::class, "pages"])->middleware("adminIsLogged");
Route::post("updatepage", [PageController::class, "updatePage"])->name("admin.pageUpdate");
Route::post("createpage", [PageController::class, "createPage"])->name("admin.pageCreate");
Route::post("deletepage", [PageController::class, "deletePage"])->name("admin.pageDelete");

//admin.payment
Route::get("admin/payment/{id?}", [PaymentController::class, "payments"])->middleware("adminIsLogged");
Route::post("updatepayment", [PaymentController::class, "updatePayment"])->name("admin.paymentUpdate");
Route::post("createpayment", [PaymentController::class, "createPayment"])->name("admin.paymentCreate");
Route::post("deletepayment", [PaymentController::class, "deletePayment"])->name("admin.paymentDelete");

//admin.shipping
Route::get("admin/shipping/{id?}", [ShippingController::class, "shippings"])->middleware("adminIsLogged");
Route::post("updateshipping", [ShippingController::class, "updateShipping"])->name("admin.shippingUpdate");
Route::post("createshipping", [ShippingController::class, "createShipping"])->name("admin.shippingCreate");
Route::post("deleteshipping", [ShippingController::class, "deleteShipping"])->name("admin.shippingDelete");

//admin.shops
Route::resource('admin/shops', ShopController::class)->middleware("adminIsLogged");
Route::resource('admin/catalogs', CatalogController::class)->middleware("adminIsLogged");

//admin.product
Route::get("admin/products", [ProductController::class, "index"]);
Route::get("admin/product/create", [ProductController::class, "create"]);
Route::post("admin/product/store", [ProductController::class, "store"])->name("admin.productCreate");
Route::get("admin/product/{id?}", [ProductController::class, "edit"]);
Route::post("admin/product/update", [ProductController::class, "update"])->name("admin.productUpdate");
Route::post("deleteproduct", [ProductController::class, "deleteProduct"])->name("admin.productDelete");
Route::post("mainImage", [ProductController::class, "mainImage"])->name("admin.mainimage");
Route::post("deletemainImage", [ProductController::class, "deleteMainImage"])->name("admin.deletemainimage");

//admin.brand
Route::get("admin/brands", [BrandController::class, "index"]);
Route::get("admin/brand/create", [BrandController::class, "create"]);
Route::post("admin/brand/store", [BrandController::class, "store"])->name("admin.brandStore");
Route::get("admin/brand/{id}", [BrandController::class, "edit"]);
Route::post("admin/brand/update", [BrandController::class, "update"])->name("admin.brandUpdate");
Route::post("admin/brand/delete/{id}", [BrandController::class, "destroy"])->name("admin.brandDelete");

//admin.garantie
Route::get("admin/garantie/{id?}", [GarantieController::class, "garantie"])->middleware("adminIsLogged");
Route::post("admin/updategarantie", [GarantieController::class, "updateGarantie"])->name("admin.garantieUpdate");
Route::post("admin/creategarantie", [GarantieController::class, "createGarantie"])->name("admin.garantieCreate");
Route::post("admin/deletegarantie", [GarantieController::class, "deleteGarantie"])->name("admin.garantieDelete");

//admin.metatags
Route::get("admin/main", [MetatagsController::class, "index"]);
Route::post("admin/main/update", [MetatagsController::class, "update"])->name("admin.metatagUpdate");

//import
Route::get("admin/importproduct", [ProductController::class, "importProduct"]);
Route::post("admin/import", [ProductController::class, "import"])->name("admin.import");