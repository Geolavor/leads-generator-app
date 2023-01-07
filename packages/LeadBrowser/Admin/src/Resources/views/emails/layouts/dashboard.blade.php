<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500" rel="stylesheet" type="text/css">
</head>

<body style="font-family: Inter, sans-serif;background: #f7f8f9;padding: 10%;">
    <div style="max-width: 1000px; margin-left: auto; margin-right: auto;">
        <div style="display: block;height: auto;width: 100%;border: 0;max-width: 353px;">
            {{ $header ?? '' }}
        </div>

        <div>
            {{ $slot }}

            {{ $subcopy ?? '' }}
        </div>

        <div>
            <div style="box-sizing:border-box;font-size:16px;width:100%;clear:both;color:#999;margin:0;padding:20px">

                <table style="box-sizing:border-box;font-size:16px;margin:0" width="100%">

                    <tbody>
                        <tr style="box-sizing:border-box;font-size:16px;margin:0">

                            <td align="center"
                                style="box-sizing:border-box;font-size:12px;vertical-align:top;color:#999;text-align:center;margin:0;padding:0 0 20px;line-height:1.4em"
                                valign="top">

                                <span class="il">LeadBrowser</span> company.

                                <br>

                                21 ul.Hlonda, Ruda Śląska 41-712

                                <br>

                                <a href="https://konstelacja.co/page/privacy-policy"
                                    style="box-sizing:border-box;font-size:12px;color:#999;text-decoration:underline;margin:0"
                                    target="_blank">Privacy Policy</a>

                            </td>

                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</body>

</html>
