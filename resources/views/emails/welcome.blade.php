<!doctype html>
<html>
<head>



</head>

<body style="font-size: 14px;">

<table cellspacing="0" cellpadding="5" border="0" width="100%">

    <tr>

        <td><img src="{{$message->embed(public_path('_assets/cubix-solutions_logo.jpg'))}}" alt="Cubix Solutions" /></td>

    </tr>

    <tr>

        <td style="color: #ffffff; background-color: #000000;">{{date('F d, Y')}}</td>
    </tr>
    <tr>

        <td>


            <p>Thank you {{$name}} for registering on our site.  Below you will find a link to activate your account.</p>
            <p><a href="http://cubix-solutions.com/account/verify">Activate Account</a></p>


        </td>

    </tr>



</table>

</body>
</html>