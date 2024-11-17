<style>.wrap span{display:inline-block;}.w260{width:260px;}.w20{width:20px;}.wauto{width:auto;}</style>
<table style="width:99.8%;height:99.8%">
    <tbody>
        <tr>
            <td style="background:#fafafa">
                <div style="border-radius:10px;font-size:13px;color:#555;width:666px;font-family:'Century Gothic','Trebuchet MS','Hiragino Sans GB',微软雅黑,'Microsoft Yahei',Tahoma,Helvetica,Arial,'SimSun',sans-serif;margin:50px auto;border:1px solid #eee;max-width:100%;background:#fff repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow:0 1px 5px rgba(0,0,0,0.15);">
                    <div style="width:100%;background:#49BDAD;color:#fff;border-radius:10px 10px 0 0;background-image:-moz-linear-gradient(0deg,rgb(67,198,184),rgb(255,209,244));background-image:-webkit-linear-gradient(0deg,rgb(67,198,184),rgb(255,209,244));height:66px;">
                        <p style="font-size:15px;word-break:break-all;padding:23px 32px;margin:0;background-color:hsla(0,0%,100%,.4);border-radius:10px 10px 0 0;">{{ option_localized('site_name') }}
                        </p>
                    </div>
                    <div style="margin:40px auto;width:90%">
                        <p>{!! trans('auth.forgot.mail.message', ['sitename' => option_localized('site_name')]) !!}</p>
                        <p>{!! trans('auth.forgot.mail.reset', ['url' => $url]) !!}</p>
                        <p>{!! trans('auth.forgot.mail.ignore') !!}</p>
                        <hr>
                        <p class="wrap" style="text-decoration:none">
                            <span class="w260">Time：{{ date('Y-m-d H:i:s') }}</span>
                            <span class="w20"> </span>
                            <span class="wauto">IP：{{ (new Vectorface\Whip\Whip())->getValidIpAddress() }}</span>
                        </p>
                        <style type="text/css">a:link,a:visited,a:hover,a:active{text-decoration:none}</style>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
