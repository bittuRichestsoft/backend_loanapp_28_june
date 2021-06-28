<!-- <a href="{{url('security/resetpassword?key='.$recovery)}}">click here </a> -->

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>@if(isset($subject) && $subject) {{$subject}} @else
    {{ \Config::get('app.name') }} @endif</title>
<meta name="viewport" content="width=device-width" />
<style type="text/css">
@media only screen and (max-width: 550px) , screen and
    (max-device-width: 550px) {
    body[yahoo] .buttonwrapper {
        background-color: transparent !important;
    }
    body[yahoo] .button {
        padding: 0 !important;
    }
    body[yahoo] .button a {
        background-color: #9b59b6;
        padding: 15px 25px !important;
    }
}

@media only screen and (min-device-width: 601px) {
    .content {
        width: 600px !important;
    }
    .col387 {
        width: 387px !important;
    }
}

ul.custom {
    text-align: left;
}

ul.custom li {
    display: block;
    width: 100%;
    height: 60px;
    margin-bottom: 10px;
    margin-left: 0px;
}

ul.custom li img {
    float: left;
    height: 60px;
}

ul.custom li label {
    margin: 14px 0px 16px 15px;
    display: inline-block;
}
</style>
</head>
<body bgcolor="" style="margin: 0; padding: 0; background: #F0F2F2;"
    yahoo="fix">
    <div style="padding: 40px; background: #F0F2F2; height: 100%;">
        <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
            <![endif]-->
        <table align="center" border="0" cellpadding="0" cellspacing="0"
            style="border-collapse: collapse; width: 100%; max-width: 600px; margin: auto;"
            class="content">
            <!-- header -->
            <tr>
                <td style="padding: 15px 10px 15px 10px;"></td>
            </tr>
            <tr>
                <td align="center" bgcolor="#ffffff"
                    style="padding: 40px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
                    <img src="{{url('images/logo.png')}}" 
                    height="60" style="display: block;" />
                </td>
            </tr>

            <tr>
                <td align="" bgcolor="#ffffff"
                    style="padding: 20px 20px 0px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 30px; border-bottom: 1px solid #f6f6f6; text-align: left;">
                    <b>Forgot Password?</b>
                </td>
            </tr>
            <tr>
                <td align="" bgcolor="#ffffff"
                    style="padding: 20px 20px 0px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 30px; border-bottom: 1px solid #f6f6f6; text-align: left;">
                    <b>Let's get you a new one!</b>
                </td>
            </tr>
            <tr>
            <td align="center" bgcolor="#f9f9f9"
                style="padding: 30px 20px 30px 20px; font-family: Arial, sans-serif;">
                <table bgcolor="#8B1E13" border="0" cellspacing="0" cellpadding="0"
                    class="buttonwrapper">
                    <tr>
                        <td align="center" height="50"
                            style="padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;"
                            class="button"><a href="{{url('admin/resetpassword?key='.$recovery)}}"
                            style="color: #ffffff; text-align: center; text-decoration: none;">Reset
                                Password</a></td>
                    </tr>
                </table>
            </td>
        </tr>


            <tr>
                <td align="" bgcolor="#ffffff"
                    style="padding: 20px 20px 0px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6; text-align: left;">

                </td>
            </tr>
            <!-- footer -->

                @include('api.email.includes.mail_footer')
        </table>
        <!--[if (gte mso 9)|(IE)]>
                    </td>
                </tr>
            </table>
            <![endif]-->
    </div>
</body>
</html>