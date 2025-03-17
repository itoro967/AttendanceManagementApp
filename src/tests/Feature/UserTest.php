<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class UserTest extends TestCase
{
    use RefreshDatabase;
    private $registerUrl = '/register';
    private $loginUrl = '/login';
    private $attendanceUrl = '/attendance';

    #ID:1
    public function testUserRegister()
    {
        $response = $this->post($this->registerUrl, [
            'email' => 'test@test.jp',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertInvalid([
            'name' => 'お名前を入力してください',
        ]);

        $response = $this->post($this->registerUrl, [
            'name' => 'test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertInvalid([
            'email' => 'メールアドレスを入力してください',
        ]);

        $response = $this->post($this->registerUrl, [
            'name' => 'test',
            'email' => 'test@test.jp',
            'password' => 'pass',
            'password_confirmation' => 'pass',
        ]);
        $response->assertInvalid([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);

        $response = $this->post($this->registerUrl, [
            'name' => 'test',
            'email' => 'test@test.jp',
            'password' => 'password',
            'password_confirmation' => 'hogehoge',
        ]);
        $response->assertInvalid([
            'password' => 'パスワードと一致しません',
        ]);

        $response = $this->post($this->registerUrl, [
            'name' => 'test',
            'email' => 'test@test.jp',
            'password_confirmation' => 'password',
        ]);
        $response->assertInvalid([
            'password' => 'パスワードを入力してください',
        ]);

        $response = $this->post($this->registerUrl, [
            'name' => 'test',
            'email' => 'test@test.jp',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect($this->attendanceUrl);
        $this->assertDatabaseHas('users', [
            'name' => 'test',
            'email' => 'test@test.jp',
        ]);
    }

    #ID:2
    public function testLogin()
    {
        $response = $this->post($this->loginUrl, [
            'password' => 'password',
        ]);
        $response->assertInvalid([
            'email' => 'メールアドレスを入力してください',
        ]);

        $response = $this->post($this->loginUrl, [
            'email' => 'test@test.jp',
        ]);
        $response->assertInvalid([
            'password' => 'パスワードを入力してください',
        ]);

        $response = $this->post($this->loginUrl, [
            'email' => 'test@test.jp',
            'password' => 'hogehoge',
        ]);
        $response->assertInvalid([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }

    #ID:3
    public function testAdminLogin()
    {
        $response = $this->post($this->loginUrl, [
            'password' => 'password',
        ]);
        $response->assertInvalid([
            'email' => 'メールアドレスを入力してください',
        ]);

        $response = $this->post($this->loginUrl, [
            'email' => 'admin@test.jp',
        ]);
        $response->assertInvalid([
            'password' => 'パスワードを入力してください',
        ]);

        $response = $this->post($this->loginUrl, [
            'email' => 'admin@test.jp',
            'password' => 'hogehoge',
        ]);
        $response->assertInvalid([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }
}
