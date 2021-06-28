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
			style="border-collapse: collapse; width: 100%; max-width: 800px; margin: auto;"
			class="content">
			<!-- header -->
			<tr>
				<td style="padding: 15px 10px 15px 10px;"></td>
			</tr>
			<tr>
				<td align="center" bgcolor="#ffffff"
					style="padding: 40px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
					<img src="<?php echo asset('assets/GIFT3R-logo.png')  ?>" alt="logo"
					height="121px" width="235" style="display: block;" />
				</td>
			</tr>

			<tr>
				<td align="" bgcolor="#ffffff"
					style="padding: 20px 20px 0px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 30px; border-bottom: 1px solid #f6f6f6; text-align: left;">
					<b>Hello</b> <span style="color:#ef4036;font-size: 16px;"><?php echo $username; ?></span>
				</td>
			</tr>
			<tr>
				<td align="" bgcolor="#ffffff"
					style="padding: 20px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 30px; border-bottom: 1px solid #f6f6f6; text-align: left;">
					<p>Here is the link.<br/> 
					</p>
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
							class="button"><a href="#"
							style="color: #ffffff; text-align: center; text-decoration: none;"><?php echo $link; ?></a></td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
				<td align="" bgcolor="#ffffff"
					style="padding: 20px 20px 0px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 30px;  text-align: left;">
					<p></p>
					<p>If you have any questions, please contact us immediately on US <span style="color:#ef4036;">+1602.820.8941</span> or <span style="color:#ef4036;">support@gift3rapp.com</span>.</p>
				</td>
			</tr>

			<tr>
				<td align="" bgcolor="#ffffff"
					style="padding: 20px 20px 0px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 30px;  text-align: left;">
					<p>For further assistance, please feel free to contact our Customer Support team at <a href="https://www.gift3rapp.com/contact-us/">https://www.gift3rapp.com/support</a>.</p>
				</td>
			</tr>

			<tr>
				<td align="" bgcolor="#ffffff"
					style="padding: 20px 20px 0px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 30px;  text-align: left;">
					Thank you,<br/>
					GIFT3R App Support

				</td>
			</tr>

			<tr>
				<td align="" bgcolor="#ffffff"
					style="padding: 20px 20px 0px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 13px; line-height: 20px;  text-align: center;">
					<a href="#">GIFT3R App User</a> | <a href="#">FAQ </a> | <a href="#">Contact</a>

				</td>
			</tr>

			<tr>
				<td align="" bgcolor="#ffffff"
					style="padding: 20px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 13px; line-height: 20px;  text-align: center;">
					<p style="color: #555555; font-family: Arial, sans-serif; font-size: 14px;line-height: 20px;">You are receiving this email because <?php echo $email ?> is signed up<br/> to receive GIFT3R App communications.<br/>
 					To adjust how often you receive future GIFT3R App emails, <br/> including unsubscribing,click here.<br/>
 					Delivered by <a href="https://www.gift3rapp.com/" style="text-decoration:none;color: #555555;">GIFT3R app</a> 4400 N. Scottsdale Rd. Ste 9-854, Scottsdale, AZ. 85251</p>

				</td>
			</tr>

			<tr>
				<td align="" bgcolor="#ffffff"
					style="padding: 20px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 13px; line-height: 20px;  text-align: center;">
					<a href="https://twitter.com/gift3rapp" target="_blank"><img src="{{asset('assets/facebook.png')}}" alt="facebook" height="30px" width="30px" /></a>
					<a href="https://www.instagram.com/gift3rapp/" target="_blank"><img src="{{asset('assets/instagram.png')}}" alt="instagram"
					height="30px" width="30px" /></a>
					<a href="https://www.facebook.com/GIFT3Rapp/?ref=settings" target="_blank"><img src="{{asset('assets/twitter.png')}}" alt="twitter"
					height="30px" width="30px" /></a>
				</td>
			</tr>
			<!-- footer -->

				
		</table>
		<!--[if (gte mso 9)|(IE)]>
                    </td>
                </tr>
            </table>
            <![endif]-->
	</div>
</body>
</html>
