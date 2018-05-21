<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


    /** Auth Routes */
    Auth::routes();



    /** Index */
    Route::get('/', 'AuthController@LoginIndex')->name('Index');

    Route::get('/TermsOfService', 'AuthController@TermsOfService')->name('TermsOfService');
    Route::get('/PrivacyPolicy', 'AuthController@PrivacyPolicy')->name('PrivacyPolicy');
    Route::get('/RefundPolicy', 'AuthController@RefundPolicy')->name('RefundPolicy');


    /** Login */
    Route::get('/Login', 'AuthController@LoginIndex')->name('Login');
    Route::post('/Login/Authenticate', 'AuthController@LoginAuthenticate')->name('LoginAuthenticate');



    /** Register */
    Route::get('/Register', 'AuthController@RegisterIndex')->name('Register');
    Route::post('/Register/Check', 'AuthController@RegisterCheck')->name('RegisterCheck');
    Route::get('/Register/VerifyEmail/{Email}/{VerificationCode}', 'AuthController@RegisterVerifyEmail')->name('RegisterVerifyEmail');
    Route::get('/Register/ResendVerificationEmail/{Email}', 'AuthController@RegisterResendVerificationEmail')->name('RegisterResendVerificationEmail');



    /** Password Reset */
    Route::get('/PasswordReset/{Email}/{Token}', 'AuthController@SetPassword')->name('PasswordReset-SetPassword');
    Route::get('/HashGen/{Password}', 'AuthController@GeneratePassword')->name('PasswordReset-HashGen');



    /** Public Plugin Routes */
    Route::get('/LatestVersion', 'PluginController@LatestVersion')->name('LatestVersion');
    Route::get('/ValidateKey', 'PluginController@ValidateKey')->name('ValidateKey');
    Route::get('/GetChatLine', 'PluginController@GetChatLine')->name('GetChatLine');
    Route::get('/AvailablePort/{CoreAuthKey}', 'PluginController@AvailablePort')->name('AvailablePort');



    /** Payments */
    //Route::get('/Payment/Initiate', 'BillingController@InitiatePayment')->name('PaymentInitiate');
    //Route::get('/Payment/Complete', 'BillingController@PaymentComplete')->name('PaymentComplete');
    //Route::get('/Payment/Cancelled', 'BillingController@PaymentCancelled')->name('PaymentCancelled');



    /** Widgets */
    Route::get('/Widget/ItemsGatheredList/{Page}', 'Widget\ItemsGatheredListController@Index')->name('ItemsGatheredListWidget');
    Route::get('/Widget/ItemsGatheredList/{Page}/Content', 'Widget\ItemsGatheredListController@GetItemsGatheredListContent')->name('GetItemsGatheredListContent');

    Route::get('/Widget/ItemsCraftedList/{Page}', 'Widget\ItemsCraftedListController@Index')->name('ItemsCraftedListWidget');
    Route::get('/Widget/ItemsCraftedList/{Page}/Content', 'Widget\ItemsCraftedListController@GetItemsCraftedListContent')->name('GetItemsCraftedListContent');

    Route::get('/Widget/ExperienceGained/{Page}', 'Widget\ExperienceGainedController@Index')->name('ExperienceGainedWidget');
    Route::get('/Widget/ExperienceGained/{Page}/Content', 'Widget\ExperienceGainedController@GetExperienceGainedContent')->name('GetExperienceGainedContent');

    Route::get('/Widget/BotBasesStatus/{Page}', 'Widget\BotBasesStatusController@Index')->name('BotBasesWidget');
    Route::get('/Widget/BotBasesStatus/{Page}/Content', 'Widget\BotBasesStatusController@GetBotBasesStatusContent')->name('GetBotBasesContent');
    Route::get('/Widget/BotBasesStatus/SelectBotBase/{BotBase}', 'Widget\BotBasesStatusController@SelectBotBase')->name('SelectBotBase');
    Route::get('/Widget/BotBasesStatus/SelectAndStartBotBase/{BotBase}', 'Widget\BotBasesStatusController@SelectAndStartBotBase')->name('SelectAndStartBotBase');
    
    Route::get('/Widget/BotStatus/{Page}', 'Widget\BotStatusController@Index')->name('BotStatusWidget');
    Route::get('/Widget/BotStatus/{Page}/Content', 'Widget\BotStatusController@GetBotStatusContent')->name('GetBotStatusContent');
    Route::get('/Widget/BotStatus/StartStopBotBase', 'Widget\BotStatusController@StartStopBotBase')->name('StartStopBotBase');
    
    Route::get('/Widget/Chat/{Page}', 'Widget\ChatController@Index')->name('ChatWidget');
    Route::get('/Widget/Chat/{Page}/Content/{LastChat}/{LastAction}/{LastBuddy}', 'Widget\ChatController@GetChatContent')->name('GetChatContent');
    
    Route::get('/Widget/FreeBagSlots/{Page}', 'Widget\FreeBagSlotsController@Index')->name('FreeBagSlotsWidget');
    Route::get('/Widget/FreeBagSlots/{Page}/Content', 'Widget\FreeBagSlotsController@GetFreeBagSlotsContent')->name('GetFreeBagSlotsContent');
    
    Route::get('/Widget/ItemsCrafted/{Page}', 'Widget\ItemsCraftedController@Index')->name('ItemsCraftedWidget');
    Route::get('/Widget/ItemsCrafted/{Page}/Content', 'Widget\ItemsCraftedController@GetItemsCraftedContent')->name('GetItemsCraftedContent');
    
    Route::get('/Widget/ItemsGathered/{Page}', 'Widget\ItemsGatheredController@Index')->name('ItemsGatheredWidget');
    Route::get('/Widget/ItemsGathered/{Page}/Content', 'Widget\ItemsGatheredController@GetItemsGatheredContent')->name('GetItemsGatheredContent');
    
    Route::get('/Widget/ItemsPurchased/{Page}', 'Widget\ItemsPurchasedController@Index')->name('ItemsPurchasedWidget');
    Route::get('/Widget/ItemsPurchased/{Page}/Content', 'Widget\ItemsPurchasedController@GetItemsPurchasedContent')->name('GetItemsPurchasedContent');
    
    Route::get('/Widget/ItemsSold/{Page}', 'Widget\ItemsSoldController@Index')->name('ItemsSoldWidget');
    Route::get('/Widget/ItemsSold/{Page}/Content', 'Widget\ItemsSoldController@GetItemsSoldContent')->name('GetItemsSoldContent');
    
    Route::get('/Widget/PluginsStatus/{Page}', 'Widget\PluginsStatusController@Index')->name('PluginsStatusWidget');
    Route::get('/Widget/PluginsStatus/{Page}/Content', 'Widget\PluginsStatusController@GetPluginsStatusContent')->name('GetPluginsStatusContent');
    Route::get('/Widget/PluginsStatus/EnableDisablePlugin/{Plugin}/{Action}', 'Widget\PluginsStatusController@EnableDisablePlugin')->name('EnableDisablePlugin');
    
    Route::get('/Widget/TimeTillLevel/{Page}', 'Widget\TimeTillLevelController@Index')->name('TimeTillLevelWidget');
    Route::get('/Widget/TimeTillLevel/{Page}/Content', 'Widget\TimeTillLevelController@GetTimeTillLevelContent')->name('GetTimeTillLevelContent');

    /** Dashboard */
    Route::get('/Dashboard', 'DashboardController@index')->name('Dashboard');

    Route::get('/Page/{Page}', 'PageController@index')->name('Page');
    Route::post('/Page/Add', 'PageController@add')->name('AddPage');
    Route::post('/Page/Update/Name/{Page}', 'PageController@UpdateName')->name('UpdatePageName');
    Route::post('/Page/Update/Icon/{Page}', 'PageController@UpdateIcon')->name('UpdatePageIcon');
    Route::get('/Page/Delete/{Page}', 'PageController@delete')->name('DeletePage');

    Route::get('/Widget/Add/{Page}/{WidgetID}', 'WidgetController@Add')->name('AddWidget');
    Route::get('/Widget/Delete/{Page}/{WidgetID}', 'WidgetController@Delete')->name('DeleteWidget');
    Route::get('/Widget/UpdateWidgetSettings/{Page}/{WidgetName}/{X}/{Y}/{Width}/{Height}', 'WidgetController@UpdateSettings')->name('UpdateWidget');

    /** Dashboard -- Top Bar */
    Route::get('/Dashboard/ExperienceGained', 'DashboardController@GetExperienceGained')->name('Dashboard-ExperienceGained');
    Route::get('/Dashboard/TimeTillLevelUp', 'DashboardController@GetTimeTillLevelUp')->name('Dashboard-TimeTillLevelUp');
    Route::get('/Dashboard/ItemsGathered', 'DashboardController@GetItemsGathered')->name('Dashboard-ItemsGathered');
    Route::get('/Dashboard/ItemsCrafted', 'DashboardController@GetItemsCrafted')->name('Dashboard-ItemsCrafted');
    Route::get('/Dashboard/FreeBagSlots', 'DashboardController@GetFreeBagSlots')->name('Dashboard-FreeBagSlots');

    /** Dashboard -- Elements */
    Route::get('/Dashboard/GetChat/{LastChat}/{LastAction}/{LastBuddy}', 'ChatController@GetChat')->name('Dashboard-GetChat');
    Route::get('/Dashboard/ItemsGatheredList', 'DashboardController@GetItemsGatheredList')->name('Dashboard-ItemsGatheredList');
    Route::get('/Dashboard/ItemsCraftedList', 'DashboardController@GetItemsCraftedList')->name('Dashboard-ItemsCraftedList');
    Route::get('/Dashboard/ItemsSoldList', 'DashboardController@GetItemsSoldList')->name('Dashboard-ItemsSoldList');
    Route::get('/Dashboard/SwitchCharacters', 'DashboardController@SwitchCharacters')->name('Dashboard-SwitchCharacters');
    Route::post('/Dashboard/UpdateElementSettings', 'DashboardController@UpdateElementSettings')->name('Dashboard-UpdateElementSettings');
    Route::post('/Dashboard/SendChat', 'ChatController@SendChat')->name('Dashboard-SendChat');
    Route::post('/Dashboard/UpdateSetting', 'DashboardController@UpdateSetting')->name('Dashboard-UpdateSetting');

    /** Bot Information */
    Route::get('/BotInfo', 'BotInfoController@Index')->name('BotInfo');
    Route::get('/BotInfo/BotStatus', 'BotInfoController@DisplayBotStatus')->name('DisplayBotStatus');
    Route::get('/BotInfo/BotBases', 'BotInfoController@DisplayBotBases')->name('DisplayBotBases');
    Route::get('/BotInfo/Plugins', 'BotInfoController@DisplayPlugins')->name('DisplayPlugins');
    Route::get('/BotInfo/StartStopBotBase', 'BotInfoController@StartStopBotBase')->name('StartStopBotBase');
    Route::get('/BotInfo/SelectBotBase/{BotBase}', 'BotInfoController@SelectBotBase')->name('SelectBotBase');
    Route::get('/BotInfo/SelectAndStartBotBase/{BotBase}', 'BotInfoController@SelectAndStartBotBase')->name('SelectAndStartBotBase');
    Route::get('/BotInfo/EnableDisablePlugin/{Plugin}/{Action}', 'BotInfoController@EnableDisablePlugin')->name('EnableDisablePlugin');

    /** Chat */
    Route::get('/Chat', 'ChatController@index')->name('Chat');

    /** Character */
    Route::get('/Character', 'CharacterController@Index')->name('Character');

    /** Inventories */
    Route::get('/Inventory', 'InventoryController@Index')->name('Inventory');

    /** Statistics */
    Route::get('/Statistics', 'StatisticsController@Index')->name('Statistics');

    /** Settings */
    Route::get('/Settings', 'SettingsController@Index')->name('Settings');
    Route::get('/Settings/PurgeAllData', 'SettingsController@PurgeAllData')->name('Settings-PurgeAllData');
    Route::post('/Settings/SaveTimezone', 'SettingsController@SaveTimezone')->name('Settings-SaveTimezone');
    Route::post('/Settings/SaveEmail', 'SettingsController@SaveEmail')->name('Settings-SaveEmail');
    Route::post('/Settings/SavePassword', 'SettingsController@SavePassword')->name('Settings-SavePassword');
    Route::post('/Settings/SaveNotifications', 'SettingsController@SaveNotifications')->name('Settings-SaveNotifications');

    /** Download */
    Route::get('/Download', 'DownloadController@Index')->name('Download');

    /** Billing */
    //Route::get('/Billing', 'BillingController@Index')->name('Billing');
    //Route::post('/Billing/SaveSubscription', 'BillingController@SaveSubscription')->name('Billing-SaveSubscription');

    /** Support */
    Route::get('/Support', 'SupportController@Index')->name('Support');

    /** Logout */
    Route::get('/Logout', 'AuthController@Logout')->name('Logout');

    Route::post('/Notifications/SetPlayerID', 'NotificationsController@SetPlayerID')->name('Notifications-SetPlayerID');
    Route::post('/Notifications/SetEnabledStatus', 'NotificationsController@SetEnabledStatus')->name('Notifications-SetEnabledStatus');

    /** Footer */
    Route::get('/Footer/CheckSocketConnection', 'DashboardController@CheckSocketConnection')->name('Footer-CheckSocketConnection');
    Route::get('/Footer/CheckDataQueueStatus', 'DashboardController@GetDataQueueStatus')->name('Footer-CheckDataQueueStatus');
    Route::get('/Footer/UpdateCurrentCharacterInfo', 'DashboardController@GetCurrentCharacterInfo')->name('Footer-UpdateCurrentCharacterInfo');