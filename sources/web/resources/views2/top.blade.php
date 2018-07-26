@extends('base')

@section('layout-json')
    <script>
        let network = {
            main: {
                id: 'title',
                position: 'center',
                childNum: 7
            },
            children: [
                {
                    id: 'new-info',
                    position: {
                        offset: {
                            x: -100,
                            y: -200
                        }
                    },
                    childNum: 0
                },
                {
                    id: 'notice',
                    position: {
                        offset: {
                            x: 100,
                            y: 100
                        }
                    },
                    childNum: 0
                },
                {
                    id: 'game',
                    position: {
                        offset: {
                            x: 100,
                            y: -130
                        }
                    },
                    childNum: 4,
                    mainMode: {
                        position: 'center',
                        parent:  {
                            position: {
                                offset: {
                                    x: -150,
                                    y: -200
                                }
                            }
                        },
                        children: [
                            {
                                id: 'game-list-phonetic',
                                position: {
                                    offset: {
                                        x: 100,
                                        y: 100
                                    }
                                },
                                dom: "<div class=\"network-item\" id=\"game-list-phonetic\">名称順</div>"
                            },
                            {
                                id: 'game-list-release',
                                position: {
                                    offset: {
                                        x: -100,
                                        y: 100
                                    }
                                },
                                dom: "<div class=\"network-item\" id=\"game-list-release\">発売日順</div>"
                            },
                            {
                                id: 'platform-list',
                                position: {
                                    offset: {
                                        x: 100,
                                        y: -100
                                    }
                                },
                                dom: "<div class=\"network-item\" id=\"platform-list\">プラットフォーム一覧</div>"
                            },
                            {
                                id: 'company-list',
                                position: {
                                    offset: {
                                        x: -100,
                                        y: -100
                                    }
                                },
                                dom: "<div class=\"network-item\" id=\"company-list\">メーカー一覧</div>"
                            }
                        ]
                    }
                },
                {
                    id: 'user',
                    position: {
                        offset: {
                            x: -80,
                            y: -100
                        }
                    },
                    childNum: 2
                },
                {
                    id: 'about',
                    position: {
                        offset: {
                            x: 50,
                            y: -210
                        }
                    },
                    childNum: 0
                },
                {
                    id: 'privacy-policy',
                    position: {
                        offset: {
                            x: 70,
                            y: 200
                        }
                    },
                    childNum: 0
                },
                {
                    id: 'site-map',
                    position: {
                        offset: {
                            x: -70,
                            y: 120
                        }
                    },
                    childNum: 0
                },
            ]
        };

        let layout = new NetworkLayout(network);
        layout.start();
    </script>
@endsection

@section('network-items')
    <div class="network-item" id="title">ホラーゲーム<br>ネットワーク</div>
    <div class="network-item" id="new-info">新着情報</div>
    <div class="network-item" id="notice">お知らせ</div>
    <div class="network-item" id="game"><a href="{{ route('ゲーム一覧') }}" class="network-change-main" data-parent-id="game">ゲーム</a></div>
    <div class="network-item" id="user">ユーザー</div>
    <div class="network-item" id="about"><a href="{{ route('当サイトについて') }}" class="network-open-main" data-parent-id="about">当サイトについて</a></div>
    <div class="network-item" id="privacy-policy">プライバシー<br>ポリシー</div>
    <div class="network-item" id="site-map">サイトマップ</div>
@endsection
