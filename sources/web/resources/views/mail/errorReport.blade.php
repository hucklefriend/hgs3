エラーが出たようです。

URL
{{ $req->fullUrl() }}

リファラ
{{ $req->headers->get('user-agent') }}

{{ $e->getMessage() }}
{{ $e->getTraceAsString() }}
