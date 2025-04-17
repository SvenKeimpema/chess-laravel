<?php

namespace Tests\Feature;

use App\Models\User;

test('we can update our username', function () {
    $new_username = "hello";
    $user = User::factory()->create();
    $resp = $this->actingAs($user)->postJson('/user/profile/username', ["username" => $new_username]);
    $resp->assertStatus(200);

    $name = User::where("id", $user->id)->first()->name;
    expect($name)->toBe($new_username);
});
