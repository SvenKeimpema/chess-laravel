<?php

test('homepage returns a successfull response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});