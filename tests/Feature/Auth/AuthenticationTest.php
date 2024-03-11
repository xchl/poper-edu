<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('teachers can login', function () {
    $response = $this->post('/oauth/token', [
        'username' => 'zhanglaoshi',
        'password' => 'poper',
        'guard' => 'teacher',
    ]);
    $response->assertStatus(200);
});

test('teachers cannot login', function () {
    $response = $this->post('/oauth/token', [
        'username' => 'zhanglaoshi',
        'password' => 'wrong password',
        'guard' => 'teacher',
    ]);

    $response->assertStatus(400);
});
test('students can login', function () {
    $response = $this->post('/oauth/token', [
        'username' => 'wangtongxue',
        'password' => 'poper',
        'guard' => 'student',
    ]);

    $response->assertStatus(200);
});

test('students cannot login', function () {
    $response = $this->post('/oauth/token', [
        'username' => 'wangtongxue',
        'password' => 'wrong password',
        'guard' => 'student',
    ]);

    $response->assertStatus(400);
});
