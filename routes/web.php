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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'MemoController@index')->name('home');

    Route::get('memos', 'MemoController@index')->name('memos.index');
    Route::get('memos/file', 'MemoController@file')->name('memos.file');
    Route::get('memos/new', 'MemoController@new')->name('memos.new');
    Route::post('memos', 'MemoController@create')->name('memos.create');
    Route::get('memos/{memo}/edit', 'MemoController@edit')->name('memos.edit');
    Route::get('memos/{memo}', 'MemoController@show')->name('memos.show');
    Route::patch('memos/{memo}', 'MemoController@update')->name('memos.update');    
    Route::post('memos/{memo}/file_uploaded', 'MemoController@fileUploaded')->name('memos.file_uploaded');
});

Auth::routes();

Route::post('/ajax/request-s3-file-signature', function() {
	// Name of the file uploaded
    $filename = Request::post('filename', '');
    $memoId = Request::post('memoId', '');
 
	// Validate file name
    if ( !preg_match("/^[ a-zA-Z0-9\._-]+$/", $filename) )
        return response()->json([
            'success' => 0,
            'message' => "Filename must contain only letters, numbers, dots, underscores and dashes.",
        ]);
 
    // Path in our S3 bucket to upload to
    $filepath = 'tests/' . $memoId . '/';
    $filename = uniqid() . '.' . pathinfo($filename, PATHINFO_EXTENSION);
 
    // Set up our policy generator being careful to add conditions that match
    // what our HTML form will be submitting to S3
    $policy = (new App\AwsPostPolicy(getenv('AWS_ACCESS'), getenv('AWS_SECRET')))
        //->addCondition('', 'acl', 'public-read')
        ->addCondition('', 'acl', 'private')
    	->addCondition('starts-with', '$key', $filepath)
    	->addCondition('', 'bucket', getenv('AWS_S3_BUCKET'))
    	->addCondition('', 'success_action_status', 200)
    	->addCondition('', 'content-type', "application/octet-stream");
 
    return response()->json([
        'success' => 1,
        'AWSAccessKeyId' => getenv('AWS_ACCESS'),
        'key' => $filepath . $filename,
        'policy' => $policy->getPolicy(),
        'signature' => $policy->getSignedPolicy(),
    ]);
})->name('request-s3-file-signature');