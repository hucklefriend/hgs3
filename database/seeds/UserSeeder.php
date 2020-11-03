<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run()
    {
        $num = 30;

        $maxId = \Hgs3\Models\User::query()
                ->max('id') + 1;

        $attrNum = count(\Hgs3\Constants\User\Attribute::$text);
        $attrMst = array_keys(\Hgs3\Constants\User\Attribute::$text);

        for ($i = 0; $i < $num; $i++) {
            $user = \Hgs3\Models\User::register([
                'name'    => self::getSampleName() . ' ' . $maxId . '号',
                'profile' => self::getSampleProfile(),
                'email'    => 'test' . $maxId . '@horrorgame.net',
                'password' => 'test3210',
            ]);

            $maxId++;

            if (rand(0, 10) >= 2) {
                $fileName = self::getSampleIconFile();
                $path = storage_path('test/user_icon/' . $fileName);

                File::copy($path, base_path('/public/img/user_icon/' . $user->id . '.png'));

                $user->icon_file_name = $user->id . '.png';
                $user->icon_upload_flag = 1;
                $user->save();
            }

            $an = intval(rand(0, $attrNum / 2));
            $attr = [];
            for ($j = 0; $j < $an; $j++) {
                $attrId = $attrMst[rand(0, 9)];
                $attr[$attrId] = $attrId;
            }

            $user->saveWithAttribute($attr);
        }
    }

    /**
     * サンプルの名前を取得
     *
     * @return string
     */
    private static function getSampleName()
    {
        $names = [
            'テストユーザー',
            'テストユーザー',
            'テストユーザー',
            'テストユーザー',
            'テストユーザー',
            'テストユーザー',
            'テストユーザー',
            'テストユーザー',
            'テストユーザー',
            '長い長い長い長い長い長い長い長い長い長い長い長い長い長い長い名前のテストユーザー',
        ];

        $i = rand(0, count($names) - 1);
        return $names[$i];
    }

    private static function getSampleProfile()
    {
        $profile = [];

        $profile[] =<<< PROFILE
本日は貴重なお時間をいただき、誠にありがとうございます。私は、●●●●と申します。◯◯大学◯◯学部を卒業後に、▲▲年に現在勤めています株式会社◯◯に新卒入社し、今年で５年目になります。営業部門に所属し、個人に対して投資用マンションの提案営業を行い、対目標比130％、対前年対比140％の実績を残すことができ、社内表彰を受賞しました。また、20代〜30代の7名のチームリーダーを任されており、マネジメントには傾聴する姿勢が大事だと考え、メンバーとは、日々多くの時間コミュニケーションを取るようにしています。顧客ニーズを解決する提案スタイルの営業には自信があります。御社の営業職でも、これまでの経験を生かして貢献できると思います。本日はどうぞよろしくお願いします。
PROFILE;

        $profile[] =<<< PROFILE
名前
私の名前は川島達史です。ちょっと珍しい名前だと言われます。タツシが噛みやすいので、自分の名前なのにたまに噛んだりしてしまいます。（軽いアイスブレイクを入れる）

住所
横浜の大口というところです。出身は鳥取県で蛍が見れるような自然があります。

趣味
趣味は最近海外のサッカーにはまっていまして、 香川選手が大好きです。深夜でも必ず試合を見ています。 見すぎているので香川選手とフィールドでプレーをしている夢をみました。

経歴
前職では医療系の機関で、メンタルヘルスやストレスの改善に関わる仕事をしていました。

意気込み
今までの知識も活かしつつ、新しいことをどんどん吸収していこうと考えています。本日からよろしくお願いします。


このような形OKでしょう。一般自己紹介は、就職活動や婚活とは違い、ピンポイントに絞らずに、浅く広くでOKです。自分の人となりを理解してもらえれば充分です。気軽に行いましょう。
PROFILE;

        $profile[] =<<< PROFILE
○○○と申します。本日はよろしくお願いいたします。私は5年間、居酒屋チェーンを経営する会社で店長業務に従事してまいりました。2年前からはエリアマネージャーとなり、特に従業員の満足度の向上に注力してきました。その結果、全社の2年以内の社員定着率が70％であるのに対し、担当エリア内では98％という成果をあげました。今回は営業職という異業種へのチャレンジですが、この経験を活かして、御社では顧客満足度の高い営業パーソンとなって売上に貢献していきたいと考えております。
PROFILE;

        $profile[] =<<< PROFILE
売上だけでなく、お客様の満足も追求できる営業になりたかった。というのが退職の動機です。
これまで私は、売上目標を達成するための努力はもちろん、売上を上げながらもお客様に満足していただけるよう、たとえば○○といった工夫を行なってきました。
しかし、現在の職場は売上重視の考え方が強く、自分の行動が受け入れられない場面もありました。
その点、御社は提案力と対応スピードの速さを強みにお持ちです。
御社であれば、自身が目指す「売上と顧客満足を両立できる営業」を実現できると考えております。
PROFILE;

        $profile[] =<<< PROFILE
私は、株式会社○○にて3年間、店舗での接客サービスを経験してきました。
学生からご年配の方までさまざまな年代のお客様と接する中で、相手に合わせたコミュニケーションの取り方や提案ができる力を身につけました。
この力を活かして店舗の売上に貢献するため、特に売り場作りでは常連のお客様に声をかけ、商品の並び方の感想やどんなアイテムがあったら嬉しいかなどを調査。
自身のこの取り組みをもとに「お客様アンケートの実施」を会社に提案し、採用していただきました。
その結果、年間売り上げ前年比120％を達成し、社内で表彰していただくこともできました。
今回は商品企画という初めての職種へのチャレンジですが、前職で培った消費者のニーズを汲み取り形にしていく力は、十分に活かせると考えています。
PROFILE;

        $profile[] =<<< PROFILE
毎日太郎と申します。前職では、飲料メーカーのマーケティング職としてキャンペーンの企画やランディングページのディレクションに携わってまいりました。「◯◯キャンペーン」では前年比120％の応募数を獲得し、社内表彰を受賞しました。
今後は、自社のマーケティングだけでなく、幅広い業種のマーケティングに挑戦していきたいと思い、キャンペーン企画を強みに多様な企業をクライアントとして持つ御社に応募させていただきました。本日はどうぞよろしくお願いいたします。
PROFILE;

        $i = rand(0, count($profile) - 1);
        return 'このユーザーはテストデータです。本運営開始時に削除されます。' . PHP_EOL . $profile[$i];
    }

    private static function getSampleIconFile()
    {
        $icons = [
            'animal_inoshishi_oyako.png',
            'medical_careboushi_flower.png',
            'monogatari_hakobune_noah_ark.png',
            'nigaoe_miyazawa_kenji.png',
            'pop_syobun_sale.png',
            'tamashii_nukeru_man.png',
            'toy_plasma_ball.png',
            'tree1_haru.png',
            'Triceratops.png',
            'udetate_man.png',
            'war_panjandrum.png',
        ];

        $i = rand(0, count($icons) - 1);
        return $icons[$i];
    }
}
