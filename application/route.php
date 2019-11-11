<?php
use think\Route;
Route::rule('login','home/login/login', 'GET|POST');
Route::rule('register','home/login/register', 'GET|POST');
Route::rule('findpwd','home/login/findpwd', 'GET|POST');
Route::rule('merchant/index','home/merchant/index', 'GET');
Route::rule('merchant/setting','home/merchant/setting', 'GET|POST');
Route::rule('merchant/address','home/merchant/address', 'GET|POST');
Route::rule('merchant/recharge','home/merchant/recharge', 'GET|POST');
Route::rule('merchant/withdraw','home/merchant/withdraw', 'GET|POST');
Route::rule('merchant/tibi','home/merchant/tibi', 'GET|POST');
Route::rule('merchant/addTiBi','home/merchant/addTiBi', 'GET|POST');
Route::rule('merchant/merchantSet','home/merchant/merchantSet', 'GET|POST');
Route::rule('merchant/applyAgent','home/merchant/applyAgent', 'GET|POST');
Route::rule('merchant/applyTrader','home/merchant/applyTrader', 'GET|POST');
Route::rule('merchant/traderrecharge','home/merchant/traderrecharge', 'GET|POST');
Route::rule('merchant/downmerchant','home/merchant/downmerchant', 'GET|POST');
Route::rule('merchant/editdown','home/merchant/editdown', 'GET|POST');
Route::rule('merchant/downapilog','home/merchant/downapilog', 'GET|POST');
Route::rule('merchant/agentreward','home/merchant/agentreward', 'GET|POST');
Route::rule('merchant/payset','home/merchant/payset', 'GET|POST');
Route::rule('merchant/newad','home/merchant/newad', 'GET|POST');
Route::rule('merchant/newadbuy','home/merchant/newadbuy', 'GET|POST');
Route::rule('merchant/orderlist','home/merchant/orderlist', 'GET|POST');
Route::rule('merchant/editad','home/merchant/editad', 'GET|POST');
Route::rule('merchant/pay','home/merchant/pay', 'GET|POST');
Route::rule('merchant/editadbuy','home/merchant/editadbuy', 'GET|POST');
Route::rule('merchant/adindex','home/merchant/adindex', 'GET');
Route::rule('merchant/addetail','home/merchant/addetail', 'GET');
Route::rule('merchant/ordersell','home/merchant/ordersell', 'GET');
Route::rule('merchant/orderlistbuy','home/merchant/orderlistbuy', 'GET');
Route::rule('merchant/log','home/merchant/log', 'GET');
Route::rule('message/index','home/message/index', 'GET');
Route::rule('message/add','home/message/add', 'GET|POST');
Route::rule('auto/autoErc','home/auto/autoErc', 'GET');
Route::rule('auto/autoEth','home/auto/autoEth', 'GET');
Route::rule('auto/autoEthTrader','home/auto/autoEthTrader', 'GET');
Route::rule('auto/selldaojishi','home/auto/selldaojishi', 'GET');
Route::rule('auto/buydaojishi','home/auto/buydaojishi', 'GET');
Route::rule('auto/statistics','home/auto/statistics', 'GET');
Route::rule('auto/downad','home/auto/downad', 'GET');
Route::rule('auto/coverusdt','home/auto/coverusdt', 'GET');
Route::rule('merchant/detail','home/merchant/detail', 'GET|POST');
Route::rule('logout','home/login/logout', 'GET');
Route::rule('merchant/traderreward','home/merchant/traderreward', 'GET|POST');
Route::rule('merchant/pkorder','home/merchant/pkorder', 'GET');
// CLI
Route::rule('auto/sellCountDown','home/auto/sellCountDown', 'GET');
Route::rule('auto/buyCountDown','home/auto/buyCountDown', 'GET');
Route::rule('auto/updateAdSellPrice','home/auto/updateAdSellPrice', 'GET');
Route::rule('auto/updateAdBuyPrice','home/auto/updateAdBuyPrice', 'GET');

Route::rule('go', 'api/redirect/go', 'GET');