<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\UploadedTorrents;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UploadedTorrentsTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(UploadedTorrents::class);

        $component->assertStatus(200);
    }
}
