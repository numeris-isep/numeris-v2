<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Message;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Message::all()->isEmpty()) {
          $this->createMessage();
        }
    }

    private function createMessage()
    {
      factory(Message::class)->create([
        'title'     => 'Test',
        'content'   => 'This is a test for MessagesTableSeeder',
      ]);
    }
}
