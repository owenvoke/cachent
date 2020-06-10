<?php

it('can test basic', function () {
    $this->get(route('home'))
        ->assertSuccessful();
});
