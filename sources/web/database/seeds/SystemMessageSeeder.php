<?php

use Illuminate\Database\Seeder;
use Hgs3\Models\Test;

class SystemMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = Test\User::get();

        foreach ($users as $user) {
            $num = rand(0, 20);

            for ($i = 0; $i < $num; $i++) {
                $msg = new \Hgs3\Models\Orm\Message();
                $msg->to_user_id = 1;
                $msg->from_user_id = $user->id;
                $msg->is_read = 0;
                $msg->message = 'こんにちは';
                $msg->save();

                unset($msg);
            }

            $num = rand(0, 10);

            for ($i = 0; $i < $num; $i++) {
                $msg = new \Hgs3\Models\Orm\Message();
                $msg->to_user_id = $user->id;
                $msg->from_user_id = 1;
                $msg->is_read = 0;
                $msg->message = 'こんばんわ';
                $msg->save();

                unset($msg);
            }
        }
    }
}
