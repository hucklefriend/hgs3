@php
    if (isset($adultSponsor) && $adultSponsor) {
        // 728x90
        $largeLinks = [
            '<a href="http://www.dmm.co.jp/lp/game/flowerknightgirl/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg017/728_90.jpg" width="728" height="90" alt="FLOWER KNIGHT GIRL~X指定~ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/aigis/index01_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg005/728_90.jpg" width="728" height="90" alt="千年戦争アイギスR　オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/inyouchu/index001.html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg026/728_90.jpg" width="728" height="90" alt="淫妖蟲 禁　～少女姦姦物語～ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/taimaninasagi/index002_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg024/728_90.jpg" width="728" height="90" alt="対魔忍アサギ～決戦アリーナ～ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/idolwarsz/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg022/728_90.jpg" width="728" height="90" alt="アイドルうぉーずZ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/goddesskissx/index003_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg035/728_90.jpg" width="728" height="90" alt="女神にキスを！" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/senpuri/index001.html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg029/728_90.jpg" width="728" height="90" alt="戦乱プリンセスG" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/kamipror/index001.html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg027/728_90.jpg" width="728" height="90" alt="神姫PROJECT R" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/killdoyar/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg038/728_90.jpg" width="728" height="90" alt="キルドヤR" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/maou/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg040/728_90.jpg" width="728" height="90" alt="魔王の始め方" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/otogir/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg039/728_90.jpg" width="728" height="90" alt="オトギフロンティアR" border="0"></a>',
            '<a href="http://www.dmm.co.jp/pr/dc/pcgame/001/=/af=hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_pcgame151/728_90.jpg" width="728" height="90" alt="ダイレクト特集ページ用バナー（ダウンロード版）" border="0"></a>',
            '<a href="http://dlsoft.dmm.co.jp/subsc/hgn-001" target="_blank"><img data-normal="http://pics.dmm.com/af/a_pcgame222/728_90.jpg" width="728" height="90" alt="DMM GAMES 遊び放題" border="0"></a>',
            '<a href="http://dlsoft.dmm.co.jp/subsc/hgn-001" target="_blank"><img data-normal="http://pics.dmm.com/af/a_pcgame223/728_90.jpg" width="728" height="90" alt="DMM GAMES 遊び放題（戦国ランス版）" border="0"></a>',
            '<a href="http://www.dmm.co.jp/mono/doujin/=/_jloff=1/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/doj_e/728_90.jpg" width="728" height="90" alt="同人通販" border="0"></a>',
            '<a href="http://www.dmm.co.jp/mono/book/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_mono_book001/728_90.jpg" width="728" height="90" alt="アダルトブック通販" border="0"></a>',
            '<a href="http://www.dmm.co.jp/dc/book/-/detail/=/cid=dmmmg_0466/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_digi_book020/728_90.jpg" width="728" height="90" alt="ロードオブワルキューレ　ダウンロード販売" border="0"></a>',
            '<a href="http://www.dmm.co.jp/dc/book/-/detail/=/cid=b289amris00786/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_digi_book035/728_90.jpg" width="728" height="90" alt="ビッチが集まるテーマパーク！水龍敬ランド～ JKもビッチ！OLもビッチ！！主婦もビッチ！！！～" border="0"></a>',
            '<a href="http://www.dmm.co.jp/dc/book/-/detail/=/cid=b195asrd00518/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_digi_book031/728_90.jpg" width="728" height="90" alt="バレたら終わり！私は親友の弟と交尾しちゃっている" border="0"></a>',
            '<a href="http://www.dmm.co.jp/dc/book/-/detail/=/cid=b289amris00632/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_digi_book029/728_90.jpg" width="728" height="90" alt="ヴァージンツィート　ダウンロード販売" border="0"></a>',
        ];


        // 468x60
        $mediumLinks = [
            '<a href="http://www.dmm.co.jp/lp/game/flowerknightgirl/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg017/468_60.jpg" width="468" height="60" alt="FLOWER KNIGHT GIRL~X指定~ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/aigis/index01_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg005/468_60.jpg" width="468" height="60" alt="千年戦争アイギスR　オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/inyouchu/index001.html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg026/468_60.jpg" width="468" height="60" alt="淫妖蟲 禁　～少女姦姦物語～ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/taimaninasagi/index002_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg024/468_60.jpg" width="468" height="60" alt="対魔忍アサギ～決戦アリーナ～ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/idolwarsz/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg022/468_60.jpg" width="468" height="60" alt="アイドルうぉーずZ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/goddesskissx/index003_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg035/468_60.jpg" width="468" height="60" alt="女神にキスを！" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/senpuri/index001.html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg029/468_60.jpg" width="468" height="60" alt="戦乱プリンセスG" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/kamipror/index001.html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg027/468_60.jpg" width="468" height="60" alt="神姫PROJECT R" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/killdoyar/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg038/468_60.jpg" width="468" height="60" alt="キルドヤR" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/maou/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg040/468_60.jpg" width="468" height="60" alt="魔王の始め方" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/otogir/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg039/468_60.jpg" width="468" height="60" alt="オトギフロンティアR" border="0"></a>',
            '<a href="http://www.dmm.co.jp/pr/dc/pcgame/001/=/af=hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_pcgame151/468_60.jpg" width="468" height="60" alt="ダイレクト特集ページ用バナー（ダウンロード版）" border="0"></a>',
            '<a href="http://dlsoft.dmm.co.jp/subsc/hgn-001" target="_blank"><img data-normal="http://pics.dmm.com/af/a_pcgame222/468_60.jpg" width="468" height="60" alt="DMM GAMES 遊び放題" border="0"></a>',
            '<a href="http://dlsoft.dmm.co.jp/subsc/hgn-001" target="_blank"><img data-normal="http://pics.dmm.com/af/a_pcgame223/468_60.jpg" width="468" height="60" alt="DMM GAMES 遊び放題（戦国ランス版）" border="0"></a>',
            '<a href="http://www.dmm.co.jp/mono/doujin/=/_jloff=1/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/doj_e/468_60.jpg" width="468" height="60" alt="同人通販" border="0"></a>',
            '<a href="http://www.dmm.co.jp/mono/book/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_mono_book001/468_60.jpg" width="468" height="60" alt="アダルトブック通販" border="0"></a>',
            '<a href="http://www.dmm.co.jp/dc/book/-/detail/=/cid=b289amris00632/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_digi_book029/468_60.jpg" width="468" height="60" alt="ヴァージンツィート　ダウンロード販売" border="0"></a>',
            '<a href="http://www.dmm.co.jp/dc/book/-/detail/=/cid=dmmmg_0466/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_digi_book020/468_60.jpg" width="468" height="60" alt="ロードオブワルキューレ　ダウンロード販売" border="0"></a>',
            '<a href="http://www.dmm.co.jp/dc/book/-/detail/=/cid=b289amris00786/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_digi_book035/468_60.jpg" width="468" height="60" alt="ビッチが集まるテーマパーク！水龍敬ランド～ JKもビッチ！OLもビッチ！！主婦もビッチ！！！～" border="0"></a>',
            '<a href="http://www.dmm.co.jp/dc/book/-/detail/=/cid=b195asrd00518/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_digi_book031/468_60.jpg" width="468" height="60" alt="バレたら終わり！私は親友の弟と交尾しちゃっている" border="0"></a>',
        ];





        // 125x125
        $smallLinks = [
            '<a href="http://www.dmm.co.jp/lp/game/flowerknightgirl/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg017/125_125.jpg" width="125" height="125" alt="FLOWER KNIGHT GIRL~X指定~ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/aigis/index01_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg005/125_125.jpg" width="125" height="125" alt="千年戦争アイギスR　オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/inyouchu/index001.html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg026/125_125.jpg" width="125" height="125" alt="淫妖蟲 禁　～少女姦姦物語～ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/taimaninasagi/index002_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg024/125_125.jpg" width="125" height="125" alt="対魔忍アサギ～決戦アリーナ～ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/idolwarsz/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg022/125_125.jpg" width="125" height="125" alt="アイドルうぉーずZ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/goddesskissx/index003_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg035/125_125.jpg" width="125" height="125" alt="女神にキスを！" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/senpuri/index001.html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg029/125_125.jpg" width="125" height="125" alt="戦乱プリンセスG" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/kamipror/index001.html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg027/125_125.jpg" width="125" height="125" alt="神姫PROJECT R" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/killdoyar/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg038/125_125.jpg" width="125" height="125" alt="キルドヤR" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/maou/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg040/125_125.jpg" width="125" height="125" alt="魔王の始め方" border="0"></a>',
            '<a href="http://www.dmm.co.jp/lp/game/otogir/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_olg039/125_125.jpg" width="125" height="125" alt="オトギフロンティアR" border="0"></a>',
            '<a href="http://www.dmm.co.jp/pr/dc/pcgame/001/=/af=hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_pcgame151/125_125.jpg" width="125" height="125" alt="ダイレクト特集ページ用バナー（ダウンロード版）" border="0"></a>',
            '<a href="http://dlsoft.dmm.co.jp/subsc/hgn-001" target="_blank"><img data-normal="http://pics.dmm.com/af/a_pcgame222/125_125.jpg" width="125" height="125" alt="DMM GAMES 遊び放題" border="0"></a>',
            '<a href="http://dlsoft.dmm.co.jp/subsc/hgn-001" target="_blank"><img data-normal="http://pics.dmm.com/af/a_pcgame223/125_125.jpg" width="125" height="125" alt="DMM GAMES 遊び放題（戦国ランス版）" border="0"></a>',
            '<a href="http://www.dmm.co.jp/mono/doujin/=/_jloff=1/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/doj_e/125_125.jpg" width="125" height="125" alt="同人通販" border="0"></a>',
            '<a href="http://www.dmm.co.jp/mono/book/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_mono_book001/125_125.jpg" width="125" height="125" alt="アダルトブック通販" border="0"></a>',
            '<a href="http://www.dmm.co.jp/dc/book/-/detail/=/cid=b289amris00632/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_digi_book029/125_125.jpg" width="125" height="125" alt="ヴァージンツィート　ダウンロード販売" border="0"></a>',
            '<a href="http://www.dmm.co.jp/dc/book/-/detail/=/cid=dmmmg_0466/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_digi_book020/125_125.jpg" width="125" height="125" alt="ロードオブワルキューレ　ダウンロード販売" border="0"></a>',
            '<a href="http://www.dmm.co.jp/dc/book/-/detail/=/cid=b289amris00786/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_digi_book035/125_125.jpg" width="125" height="125" alt="ビッチが集まるテーマパーク！水龍敬ランド～ JKもビッチ！OLもビッチ！！主婦もビッチ！！！～" border="0"></a>',
            '<a href="http://www.dmm.co.jp/dc/book/-/detail/=/cid=b195asrd00518/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/a_digi_book031/125_125.jpg" width="125" height="125" alt="バレたら終わり！私は親友の弟と交尾しちゃっている" border="0"></a>',
        ];
    } else {
        // 728x90
        $largeLinks = [
            '<a href="http://www.dmm.com/netgame/feature/ensemble_stars.html/hgn-001" target="_blank"><img data-normal="http://pics.dmm.com/af/c_olg052/728_90.jpg" width="728" height="90" alt="あんさんぶるスターズ！" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/doax/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg046/728_90.jpg" width="728" height="90" alt="DEAD OR ALIVE Xtreme Venus Vacation" border="0"></a>',
            '<a href="https://www.dmm.com/lp/game/pkill/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg045/728_90.jpg" width="728" height="90" alt="ファントムオブキル" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/bungo/index001.html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg039/728_90.jpg" width="728" height="90" alt="文豪とアルケミスト" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/icchibanketu/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg040/728_90.jpg" width="728" height="90" alt="一血卍傑-ONLINE-" border="0"></a>',
            '<a href="http://www.dmm.com/monthly/prime/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mt_prime3/728_90.jpg" width="728" height="90" alt="見放題chライト" border="0"></a>',
            '<a href="http://www.dmm.com/monthly/prime/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mt_prime2/728_90.jpg" width="728" height="90" alt="見放題chライト2" border="0"></a>',
            '<a href="http://dlsoft.dmm.com/subsc/hgn-001" target="_blank"><img data-normal="http://pics.dmm.com/af/c_pcgame006/728_90.jpg" width="728" height="90" alt="DMM GAMES 遊び放題" border="0"></a>',
            '<a href="http://dlsoft.dmm.com/detail/vsat_0184/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_pcgame001/728_90.jpg" width="728" height="90" alt="Angel Beats!-1st beat- ダウンロード販売" border="0"></a>',
            '<a href="http://www.dmm.com/mono/book/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mono_book/728_90.jpg" width="728" height="90" alt="本・コミック通販" border="0"></a>',
            '<a href="http://www.dmm.com/mono/dvd/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mono/728_90.jpg" width="728" height="90" alt="DVD通販" border="0"></a>',
            '<a href="http://www.dmm.com/mono/hobby/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_monohobby/728_90.jpg" width="728" height="90" alt="ホビー・フィギュア通販" border="0"></a>',
            '<a href="http://www.dmm.com/mono/game/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mono_game/728_90.jpg" width="728" height="90" alt="ゲーム通販" border="0"></a>',
            '<a href="http://book.dmm.com/comic/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi_book003/728_90.jpg" width="728" height="90" alt="電子書籍 コミック" border="0"></a>',
            '<a href="http://book.dmm.com/detail/b428ajlan00185/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi_book007/728_90.jpg" width="728" height="90" alt="パーフェクトプラネット" border="0"></a>',
            '<a href="http://book.dmm.com/detail/b525asmh00852/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi_book008/728_90.jpg" width="728" height="90" alt="求ム！理想の年下上司 ダウンロード販売" border="0"></a>',
            '<a href="http://www.dmm.com/digital/video/-/list/=/sort=ranking/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi001/728_90.jpg" width="728" height="90" alt="VR動画" border="0"></a>',
            '<a href="http://www.dmm.com/digital/video/-/list/=/sort=ranking/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi002/728_90.jpg" width="728" height="90" alt="VR動画" border="0"></a>',
            '<a href="http://www.dmm.com/digital/video/-/list/=/sort=ranking/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi003/728_90.jpg" width="728" height="90" alt="VR動画" border="0"></a>',
            '<a href="http://www.dmm.com/rental/comic/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_rental_comic/728_90.jpg" width="728" height="90" alt="コミックレンタル" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/aigis/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg010/728_90.jpg" width="728" height="90" alt="千年戦争アイギス　オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/flowerknightgirl/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg018/728_90.jpg" width="728" height="90" alt="FLOWER KNIGHT GIRL　オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/kanpani/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg025/728_90.jpg" width="728" height="90" alt="かんぱに☆ガールズ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/toukenranbu/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg024/728_90.jpg" width="728" height="90" alt="刀剣乱舞-ONLINE- オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/kamipro/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg030/728_90.jpg" width="728" height="90" alt="神姫PROJECT" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/oshirore/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg031/728_90.jpg" width="728" height="90" alt="御城プロジェクト～CASTLEDEFENCE～" border="0"></a>',
        ];

        // 468x60
        $mediumLinks = [
            '<a href="http://www.dmm.com/netgame/feature/ensemble_stars.html/hgn-001" target="_blank"><img data-normal="http://pics.dmm.com/af/c_olg052/468_60.jpg" width="468" height="60" alt="あんさんぶるスターズ！" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/doax/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg046/468_60.jpg" width="468" height="60" alt="DEAD OR ALIVE Xtreme Venus Vacation" border="0"></a>',
            '<a href="https://www.dmm.com/lp/game/pkill/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg045/468_60.jpg" width="468" height="60" alt="ファントムオブキル" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/bungo/index001.html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg039/468_60.jpg" width="468" height="60" alt="文豪とアルケミスト" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/icchibanketu/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg040/468_60.jpg" width="468" height="60" alt="一血卍傑-ONLINE-" border="0"></a>',
            '<a href="http://www.dmm.com/monthly/prime/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mt_prime3/468_60.jpg" width="468" height="60" alt="見放題chライト" border="0"></a>',
            '<a href="http://www.dmm.com/monthly/prime/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mt_prime2/468_60.jpg" width="468" height="60" alt="見放題chライト2" border="0"></a>',
            '<a href="http://dlsoft.dmm.com/subsc/hgn-001" target="_blank"><img data-normal="http://pics.dmm.com/af/c_pcgame006/468_60.jpg" width="468" height="60" alt="DMM GAMES 遊び放題" border="0"></a>',
            '<a href="http://dlsoft.dmm.com/detail/vsat_0184/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_pcgame001/468_60.jpg" width="468" height="60" alt="Angel Beats!-1st beat- ダウンロード販売" border="0"></a>',
            '<a href="http://www.dmm.com/mono/book/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mono_book/468_60.jpg" width="468" height="60" alt="本・コミック通販" border="0"></a>',
            '<a href="http://www.dmm.com/mono/dvd/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mono/468_60.jpg" width="468" height="60" alt="DVD通販" border="0"></a>',
            '<a href="http://www.dmm.com/mono/hobby/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_monohobby/468_60.jpg" width="468" height="60" alt="ホビー・フィギュア通販" border="0"></a>',
            '<a href="http://www.dmm.com/mono/game/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mono_game/468_60.jpg" width="468" height="60" alt="ゲーム通販" border="0"></a>',
            '<a href="http://book.dmm.com/comic/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi_book003/468_60.jpg" width="468" height="60" alt="電子書籍 コミック" border="0"></a>',
            '<a href="http://book.dmm.com/detail/b428ajlan00185/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi_book007/468_60.jpg" width="468" height="60" alt="パーフェクトプラネット" border="0"></a>',
            '<a href="http://book.dmm.com/detail/b525asmh00852/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi_book008/468_60.jpg" width="468" height="60" alt="求ム！理想の年下上司 ダウンロード販売" border="0"></a>',
            '<a href="http://www.dmm.com/digital/video/-/list/=/sort=ranking/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi001/468_60.jpg" width="468" height="60" alt="VR動画" border="0"></a>',
            '<a href="http://www.dmm.com/digital/video/-/list/=/sort=ranking/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi002/468_60.jpg" width="468" height="60" alt="VR動画" border="0"></a>',
            '<a href="http://www.dmm.com/digital/video/-/list/=/sort=ranking/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi003/468_60.jpg" width="468" height="60" alt="VR動画" border="0"></a>',
            '<a href="http://www.dmm.com/rental/comic/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_rental_comic/468_60.jpg" width="468" height="60" alt="コミックレンタル" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/aigis/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg010/468_60.jpg" width="468" height="60" alt="千年戦争アイギス　オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/flowerknightgirl/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg018/468_60.jpg" width="468" height="60" alt="FLOWER KNIGHT GIRL　オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/kanpani/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg025/468_60.jpg" width="468" height="60" alt="かんぱに☆ガールズ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/toukenranbu/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg024/468_60.jpg" width="468" height="60" alt="刀剣乱舞-ONLINE- オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/kamipro/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg030/468_60.jpg" width="468" height="60" alt="神姫PROJECT" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/oshirore/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg031/468_60.jpg" width="468" height="60" alt="御城プロジェクト～CASTLEDEFENCE～" border="0"></a>',
        ];

        // 125x125
        $smallLinks = [
            '<a href="http://www.dmm.com/netgame/feature/ensemble_stars.html/hgn-001" target="_blank"><img data-normal="http://pics.dmm.com/af/c_olg052/125_125.jpg" width="125" height="125" alt="あんさんぶるスターズ！" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/doax/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg046/125_125.jpg" width="125" height="125" alt="DEAD OR ALIVE Xtreme Venus Vacation" border="0"></a>',
            '<a href="https://www.dmm.com/lp/game/pkill/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg045/125_125.jpg" width="125" height="125" alt="ファントムオブキル" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/bungo/index001.html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg039/125_125.jpg" width="125" height="125" alt="文豪とアルケミスト" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/icchibanketu/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg040/125_125.jpg" width="125" height="125" alt="一血卍傑-ONLINE-" border="0"></a>',
            '<a href="http://www.dmm.com/monthly/prime/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mt_prime3/125_125.jpg" width="125" height="125" alt="見放題chライト" border="0"></a>',
            '<a href="http://www.dmm.com/monthly/prime/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mt_prime2/125_125.jpg" width="125" height="125" alt="見放題chライト2" border="0"></a>',
            '<a href="http://dlsoft.dmm.com/subsc/hgn-001" target="_blank"><img data-normal="http://pics.dmm.com/af/c_pcgame006/125_125.jpg" width="125" height="125" alt="DMM GAMES 遊び放題" border="0"></a>',
            '<a href="http://dlsoft.dmm.com/detail/vsat_0184/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_pcgame001/125_125.jpg" width="125" height="125" alt="Angel Beats!-1st beat- ダウンロード販売" border="0"></a>',
            '<a href="http://www.dmm.com/mono/book/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mono_book/125_125.jpg" width="125" height="125" alt="本・コミック通販" border="0"></a>',
            '<a href="http://www.dmm.com/mono/dvd/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mono/125_125.jpg" width="125" height="125" alt="DVD通販" border="0"></a>',
            '<a href="http://www.dmm.com/mono/hobby/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_monohobby/125_125.jpg" width="125" height="125" alt="ホビー・フィギュア通販" border="0"></a>',
            '<a href="http://www.dmm.com/mono/game/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_mono_game/125_125.jpg" width="125" height="125" alt="ゲーム通販" border="0"></a>',
            '<a href="http://book.dmm.com/comic/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi_book003/125_125.jpg" width="125" height="125" alt="電子書籍 コミック" border="0"></a>',
            '<a href="http://book.dmm.com/detail/b428ajlan00185/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi_book007/125_125.jpg" width="125" height="125" alt="パーフェクトプラネット" border="0"></a>',
            '<a href="http://book.dmm.com/detail/b525asmh00852/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi_book008/125_125.jpg" width="125" height="125" alt="求ム！理想の年下上司 ダウンロード販売" border="0"></a>',
            '<a href="http://www.dmm.com/digital/video/-/list/=/sort=ranking/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi001/125_125.jpg" width="125" height="125" alt="VR動画" border="0"></a>',
            '<a href="http://www.dmm.com/digital/video/-/list/=/sort=ranking/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi002/125_125.jpg" width="125" height="125" alt="VR動画" border="0"></a>',
            '<a href="http://www.dmm.com/digital/video/-/list/=/sort=ranking/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_digi003/125_125.jpg" width="125" height="125" alt="VR動画" border="0"></a>',
            '<a href="http://www.dmm.com/rental/comic/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_rental_comic/125_125.jpg" width="125" height="125" alt="コミックレンタル" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/aigis/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg010/125_125.jpg" width="125" height="125" alt="千年戦争アイギス　オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/flowerknightgirl/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg018/125_125.jpg" width="125" height="125" alt="FLOWER KNIGHT GIRL　オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/kanpani/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg025/125_125.jpg" width="125" height="125" alt="かんぱに☆ガールズ オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/toukenranbu/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg024/125_125.jpg" width="125" height="125" alt="刀剣乱舞-ONLINE- オンラインゲーム" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/kamipro/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg030/125_125.jpg" width="125" height="125" alt="神姫PROJECT" border="0"></a>',
            '<a href="http://www.dmm.com/lp/game/oshirore/index001_html/=/navi=none/hgn-001" target="_blank"><img data-normal="https://pics.dmm.com/af/c_olg031/125_125.jpg" width="125" height="125" alt="御城プロジェクト～CASTLEDEFENCE～" border="0"></a>'
        ];
    }

    $large = $largeLinks[rand(0, count($largeLinks) - 1)];
    $medium = $mediumLinks[rand(0, count($mediumLinks) - 1)];
    $smallIdx = rand(0, count($smallLinks) - 1);
    $small1 = $smallLinks[$smallIdx];
    unset($smallLinks[$smallIdx]);
    $smallLinks = array_values($smallLinks);
    $small2 = $smallLinks[rand(0, count($smallLinks) - 1)];
@endphp

<div class="sponsor sponser-footer d-flex justify-content-center">
    <div class="hidden-sm-down text-left">
        <p class="text-muted mb-1"><small>スポンサーリンク</small></p>
        {!! $large !!}
    </div>
    <div class="hidden-xs-down hidden-md-up text-left">
        <p class="text-muted mb-1"><small>スポンサーリンク</small></p>
        {!! $medium !!}
    </div>
    <div class="hidden-sm-up text-left">
        <p class="text-muted mb-1"><small>スポンサーリンク</small></p>
        <div class="row">
            <div class="col-6 text-center">
                {!! $small1 !!}
            </div>
            <div class="col-6 text-center">
                {!! $small2 !!}
            </div>
        </div>
    </div>
</div>
