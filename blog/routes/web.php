<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Http\Response;

//<使用者>
//顯示租借空間------------------------------------------------------------------------------------
//新增areas Table以及Area Model
$router->get('/getAreas', 'Area@getAreas'); //顯示選單建築物(return 建築物) ok ok
//新增floors Table以及Floor Model
$router->get('/getFloors/{area}', 'Floor@getFloors');   //顯示可選單樓層(return 樓層) ok
//修改paces Table以及Space Model(刪除area及floor 有關之function)
$router->get('getRooms/{area?}/{floor?}', 'Space@getRooms');

$router->get('getRooms', 'Space@getRooms');
$router->get('getRooms/{area}', 'Space@getRooms');
$router->get('getRooms/{area}/{floor}', 'Space@getRooms');    //顯示可選單空間(return 空間) ok

$router->get('/getAllAvailableBooking/{space_id}', 'Booking@getAllAvailableBooking');  //顯示可預約空間(return 時間) ok
$router->post('/newBooking', 'Booking@newBooking'); //新增預約空間 ok ok

//個人資料顯示-------------------------------------------------------------------------------------
$router->get('/getUserInfo', 'User@getUserInfo'); //顯示個人資料 ok ok
//顯示預約紀錄-------------------------------------------------------------------------------------
$router->get('/getAllBooking', 'Booking@getAllBooking'); //顯示個人預約紀錄 ok ok
$router->delete('/removeBooking/{booking_id}', 'Booking@removeBooking'); //刪除個人預約紀錄 ok ok
//修改預約紀錄-------------------------------------------------------------------------------------
$router->get('/getBooking/{booking_id}', 'Booking@getBooking'); //顯示單一預約紀錄 ok ok
$router->put('/updateBooking1', 'Booking@updateBooking1');//日曆拖曳
$router->put('/updateBooking', 'Booking@updateBooking'); //修改預約紀錄 ok ok
//回饋表單------------------------------------------------------------------------------------
$router->post('/newReport', 'Report@newReport'); //新增回饋 ok ok
//修改密碼------------------------------------------------------------------------------------
$router->put('/updatepassword', 'User@updatepassword');

//-----------------------------------------------------------------------------------------------------
//<管理者>
//查詢各空間管理----------------------------------------------------------------------------------------
$router->get('/getAllRoom/{area}', ['middleware' => 'actions:admin', 'uses' => 'Space@getAllRoom']); //顯示各空間 ok ok
//新增floors Table以及Floor Model
$router->get('/getAllFloors', [
    'middleware' => 'actions:admin',
    'uses' => 'Floor@getAllFloors'
]); //取得所有樓層(測試) 不需要用~
//刪除各空間-------------------------------------------------------------------------------------------
$router->delete('/removeRoom/{space_id}',  ['middleware' => 'actions:admin', 'uses' => 'Space@removeRoom']); //刪除各空間 ok ok
//新增各空間-------------------------------------------------------------------------------------------
$router->get('/getAllClasses',  ['middleware' => 'actions:admin', 'uses' => 'Classes@getAllClasses']); //取得會議室類別 ok ok
$router->post('/newRoom', [
    'middleware' => 'actions:admin',
    'uses' => 'Space@newRoom'
]); //新增各空間 ok ok
$router->put('/updateRoom',  ['middleware' => 'actions:admin', 'uses' => 'Space@updateRoom']); //修改各空間 ok ok
$router->get('/getAllDept',  ['middleware' => 'actions:admin', 'uses' => 'Dept@getAllDept']); //顯示所有部門 ok ok
$router->get('/getUser',  ['middleware' => 'actions:admin', 'uses' => 'User@getUser']); //顯示使用者 ok ok
$router->delete('/deleteUser/{emp_id}',  ['middleware' => 'actions:admin', 'uses' => 'User@deleteUser']); //刪除使用者 ok ok
$router->get('/getRoomRecord/{area}/{floor}/{room}',  ['middleware' => 'actions:admin', 'uses' => 'RoomRecord@getRoomRecord']); //顯示開門紀錄 ok ok
$router->get('/getAllRoomRecord',  ['middleware' => 'actions:admin', 'uses' => 'RoomRecord@getAllRoomRecord']);//顯示所有開門紀錄
$router->get('/getUserReport',  ['middleware' => 'actions:admin', 'uses' => 'Report@getUserReport']); //問題回饋管理 ok ok
$router->post('/newUser', ['middleware' => 'actions:admin', 'uses' =>  'User@newUser']);
$router->put('/updateUser', ['middleware' => 'actions:admin', 'uses' =>  'User@updateUser']);
$router->delete('/removeUser', ['middleware' => 'actions:admin', 'uses' =>  'User@removeUser']);
$router->post('/testMiddleware', [
    'middleware' => ['first', 'second'],
    function () {
        return "function is here";
    }
]);
//admin(updateRoom)抓floor,space
$router->get('/getfloorandspace', 'Space@getfloorandspace');
//問題回饋勾選
$router->put('/updatedealwith', 'Report@updatedealwith');
