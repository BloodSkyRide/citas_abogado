<?php
use App\Http\Controllers\tokenController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\historySubLaborsController;
use App\Http\Controllers\subLaborsController;
use App\Http\Controllers\laborController;
use App\Http\Controllers\assistController;
use App\Http\Controllers\userController;
use App\Http\Controllers\scheduleController;
use App\Http\Controllers\payrollController;
use App\Http\Controllers\overTimeController;
use App\Http\Controllers\createProductController;
use App\Http\Controllers\inventoryController;
use App\Http\Controllers\historySellController;
use App\Http\Controllers\employeFoodController;
use App\Http\Controllers\guestController; 
use App\Http\Controllers\contabilityController;
use App\Http\Controllers\kitchenController;
use App\Http\Controllers\transfersController;
use App\Http\Controllers\chatBotController;
 




use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name("home");



//Route::post('/token', [tokenController::class, 'token'])->name("token");
Route::post('/login', [AuthController::class, 'login']);


Route::post('/logout', [AuthController::class, 'logout'])->name("logout")->middleware(["verifyTokenHeader"]);


Route::get('/refresh', [AuthController::class, 'refresh'])->middleware(["verificar_token"]);

Route::get('/me', [AuthController::class, 'me'])->middleware(["verificar_token"]);
Route::get('/dashboard', [dashboardController::class, 'openView'])->name("dashboard")->middleware(["verificar_token"]);
Route::get('/registerUser', [dashboardController::class, 'viewRegister'])->name("registroUser")->middleware(["verifyTokenHeader"]);

Route::post('/saveUser', [dashboardController::class, 'saveUser'])->name("saveUser")->middleware(["verifyTokenHeader"]);



Route::get('/showManageLabor', [dashboardController::class, 'showManageLabor'])->name("showManageLabor")->middleware(["verifyTokenHeader"]); //verificador de middleware

Route::get('/showAssists', [dashboardController::class, 'getShowAssist'])->name("getShowAssist")->middleware(["verifyTokenHeader"]);

Route::get('/showMyLabors', [dashboardController::class, 'getShowMyLabors'])->name("showMyLabors")->middleware(["verifyTokenHeader"]);

Route::post('/insertSubLabor', [subLaborsController::class, 'insertSubLabor'])->name("insertSubLabor")->middleware(["verifyTokenHeader"]);

Route::delete('/Deletes', [subLaborsController::class, 'deleteSubLabors'])->name("Deletes")->middleware(["verifyTokenHeader"]);

Route::post('/insertlabor', [laborController::class, 'insertLabor'])->name("insertlabor")->middleware(["verifyTokenHeader"]);

Route::put('/modifylabor', [laborController::class, 'editLabor'])->name("editLabor")->middleware(["verifyTokenHeader"]);

Route::post('/historySubLabor', [subLaborsController::class, 'historySubLabor'])->name("historySubLabor")->middleware(["verifyTokenHeader"]);

Route::put('/rechargeSubLabors', [subLaborsController::class, 'rechargeSubLabors'])->name("rechargeSubLabors")->middleware(["verifyTokenHeader"]);

Route::post('/captureHour', [assistController::class, 'captureHour'])->name("captureHour")->middleware(["verifyTokenHeader"]);

Route::get('/historyLabors', [historySubLaborsController::class, 'getShowHistorySubLabors'])->name("getShowHistorySubLabors")->middleware(["verifyTokenHeader"]);
Route::get('/searchForRange', [historySubLaborsController::class, 'searchForRange'])->name("searchForRange")->middleware(["verifyTokenHeader"]);

Route::get('/searchText', [historySubLaborsController::class, 'searchText'])->name("searchText")->middleware(["verifyTokenHeader"]);

Route::post('/collectSubLabors', [historySubLaborsController::class, 'collectSubLabors'])->name("collectSubLabors")->middleware(["verifyTokenHeader"]);

Route::put('/secure', [assistController::class, 'secure'])->name("secure")->middleware(["verifyTokenHeader"]);

Route::get('/getshowreportassists', [assistController::class, 'getShowReportAssists'])->name("getShowReportAssists")->middleware(["verifyTokenHeader"]);



Route::get('/getshowusers', [dashboardController::class, 'getShowUserAdmin'])->name("getShowUsers")->middleware(["verifyTokenHeader"]);


Route::get('/getUser', [userController::class, 'getUserForId'])->name("getUserForId")->middleware(["verifyTokenHeader"]);


Route::put('/modifyuser', [userController::class, 'modifyUser'])->name("modifyUser")->middleware(["verifyTokenHeader"]);

Route::delete('/deleteuser', [userController::class, 'deleteUser'])->name("deleteUser")->middleware(["verifyTokenHeader"]);

Route::put('/changePasswordShow', [dashboardController::class, 'changePasswordShow'])->name("changePasswordShow")->middleware(["verifyTokenHeader"]);

Route::put('/changepassword', [userController::class, 'changePassword'])->name("changePassword")->middleware(["verifyTokenHeader"]);



Route::get('/shownotices', [dashboardController::class, 'getShowNotices'])->name("getShowNotices")->middleware(["verifyTokenHeader"]);

Route::get('/showrangeassists', [assistController::class, 'getShowAssistRange'])->name("showrangeassists")->middleware(["verifyTokenHeader"]);

Route::get('/schedules', [scheduleController::class, 'getShowSchedule'])->name("getShowSchedule")->middleware(["verifyTokenHeader"]);

Route::put('/insertSchedule', [scheduleController::class, 'insertSchedule'])->name("insertSchedule")->middleware(["verifyTokenHeader"]);

Route::post('/scheduleclear', [scheduleController::class, 'scheduleclear'])->name("scheduleclear")->middleware(["verifyTokenHeader"]);


Route::put('/deleteclear', [scheduleController::class, 'deleteclear'])->name("deleteclear")->middleware(["verifyTokenHeader"]);
Route::get('/getshowpayroll', [payrollController::class, 'getshowpayroll'])->name("getshowpayroll")->middleware(["verifyTokenHeader"]);


Route::get('/getHistoryPayRoll', [payrollController::class, 'getHistoryPayRoll'])->name("getHistoryPayRoll")->middleware(["verifyTokenHeader"]);

Route::post('/insertpdf', [payrollController::class, 'insertsPdfs'])->name("insertsPdfs")->middleware(["verifyTokenHeader"]);

Route::get('/downloadPdf/{nombre_archivo}', [payrollController::class, 'downloadPdf'])->name("downloadPdf")->middleware(["verifyTokenHeader"]);



/////////////////////////////////prueba de rutas para websockets

Route::get('/emitir-evento', [dashboardController::class, 'emitirEvento']);// ruta de prueba disparador de evento


Route::get('/getShowOverTime', [dashboardController::class, 'getShowOverTime'])->name("getShowOverTime")->middleware(["verifyTokenHeader"]);


Route::post('/sendOverTime', [overTimeController::class, 'sendOverTime'])->name("sendOverTime")->middleware(["verifyTokenHeader"]);

Route::get('/getShowOverTimeAdmin', [overTimeController::class, 'getShowOverTimeAdmin'])->name("getShowOverTimeAdmin")->middleware(["verifyTokenHeader"]);

Route::put('/changeStateOverTime', [overTimeController::class, 'changeStateOverTime'])->name("changeStateOverTime")->middleware(["verifyTokenHeader"]);

Route::get('/createProducts', [createProductController::class, 'createProducts'])->name("createProduct")->middleware(["verifyTokenHeader"]);

Route::post('/saveproduct', [createProductController::class, 'saveProduct'])->name("saveProduct")->middleware(["verifyTokenHeader"]);

Route::get('/getShowStore', [createProductController::class, 'getShowStore'])->name("getShowStore")->middleware(["verifyTokenHeader"]);
Route::post('/searcher', [createProductController::class, 'getSearch'])->name("searcher")->middleware(["verifyTokenHeader"]);

Route::post('/sell', [createProductController::class, 'sell'])->name("sell")->middleware(["verifyTokenHeader"]);


Route::get('/getShowInventory', [inventoryController::class, 'getShowInventory'])->name("getShowInventory")->middleware(["verifyTokenHeader"]);

Route::post('/saveInventory', [inventoryController::class, 'saveInventory'])->name("saveInventory")->middleware(["verifyTokenHeader"]);

Route::put('/editInventory', [inventoryController::class, 'editInventory'])->name("editInventory")->middleware(["verifyTokenHeader"]);

Route::post('/delete', [inventoryController::class, 'deleteInventory'])->name("deleteInventory")->middleware(["verifyTokenHeader"]);
Route::post('/control-inventario', [inventoryController::class, 'insertIventoryControl'])->name("controlInventory")->middleware(["verifyTokenHeader"]);

Route::get('/getShowHistorySell', [historySellController::class, 'getShowHistorySell'])->name("getShowHistorySell")->middleware(["verifyTokenHeader"]);

Route::post('/searchForRangeHistory', [historySellController::class, 'searchForRangeHistory'])->name("searchForRangeHistory")->middleware(["verifyTokenHeader"]);

Route::post('/editCompund', [createProductController::class, 'editProductCompund'])->name("editProductCompund")->middleware(["verifyTokenHeader"]);

Route::post('/deleteCompound', [createProductController::class, 'deleteCompound'])->name("deleteCompound")->middleware(["verifyTokenHeader"]);

Route::get('/getShowEmployeeFood', [employeFoodController::class, 'getShowEmployeeFood'])->name("getShowEmployeeFood")->middleware(["verifyTokenHeader"]);
Route::post('/search-range-food', [employeFoodController::class, 'searchForRangeFood'])->name("search-range-food")->middleware(["verifyTokenHeader"]);

Route::post('/insertFood', [employeFoodController::class, 'insertFood'])->name("insertFood")->middleware(["verifyTokenHeader"]);
Route::post('/getShowGuest', [guestController::class, 'getShowGuest'])->name("getShowGuest")->middleware(["verifyTokenHeader"]);
Route::post('/sendregister', [guestController::class, 'sendregister'])->name("sendregister")->middleware(["verifyTokenHeader"]);
Route::post('/serachForRangeGuest', [guestController::class, 'getRange'])->name("serachForRangeGuest")->middleware(["verifyTokenHeader"]);

Route::post('/informationProduct', [createProductController::class, 'informationProduct'])->name("informationProduct")->middleware(["verifyTokenHeader"]);

Route::get('/contability', [contabilityController::class, 'getShowContability'])->name("contability")->middleware(["verifyTokenHeader"]);

Route::post('/upload-egress', [contabilityController::class, 'uploadEgress'])->name("uploadEgress")->middleware(["verifyTokenHeader"]);
Route::post('/egress-date', [contabilityController::class, 'egressForDate'])->name("egressDate")->middleware(["verifyTokenHeader"]);
Route::get('/show-transfers', [transfersController::class, 'getShowTransfers'])->name("getShowTransfers")->middleware(["verifyTokenHeader"]);
Route::post('/insert-transfer', [transfersController::class, 'insertTransfer'])->name("insertTransfer")->middleware(["verifyTokenHeader"]);
Route::post('/search-range', [transfersController::class, 'searchForRangeTransfers'])->name("search-range-transfers")->middleware(["verifyTokenHeader"]);
Route::post('/make-reservation', [guestController::class, 'makeReservation'])->name("reservation")->middleware(["verifyTokenHeader"]);
Route::post('/search-reservation', [guestController::class, 'searchReservation'])->name("searchReservation")->middleware(["verifyTokenHeader"]);
Route::post('/redeem-code', [guestController::class, 'redeemCode'])->name("redeemCode")->middleware(["verifyTokenHeader"]);
Route::post('/orderkitchen', [kitchenController::class, 'orderkitchen'])->name("orderkitchen")->middleware(["verifyTokenHeader"]);
Route::get('/cocina', [kitchenController::class, 'getShowKitchen'])->name("showKitchen")->middleware(["verifyTokenHeader"]);

Route::post('/cambiar-estado-cocina', [kitchenController::class, 'changeState'])->name("changeState")->middleware(["verifyTokenHeader"]);
Route::post('/cambiar-estado-button', [kitchenController::class, 'changeStateButton'])->name("changeStateButton")->middleware(["verifyTokenHeader"]);
Route::get('/verifyPermission', [kitchenController::class, 'getIdUser'])->name("verifyPermission")->middleware(["verifyTokenHeader"]);

Route::post('/rango-cocina', [kitchenController::class, 'getRange'])->name("rangeKitchen")->middleware(["verifyTokenHeader"]);

///////////chat bot .//////////

Route::match(['GET', 'POST'], '/webhook', [chatBotController::class, 'chatBot']);

Route::post('/opcion-historialventas', [historySellController::class, 'optionalHistorySell'])->name("optionalHistorySell")->middleware(["verifyTokenHeader"]);



