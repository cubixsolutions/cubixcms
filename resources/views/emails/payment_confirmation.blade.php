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


            <p>Thank you {{$name}} for you're payment in the amount of ${{$amount}}.  You will see a charge from CUBIX-SOLUTIONS.COM on your next bank statement.
                If you have any questions regarding this payment or if you never authorized this payment, please contact us for assistance.</p>
            <p>Thank you again for you're payment and we appreciate your business.</p>
            <p>Sean Pollock<br />
            Cubix Solutions</p>


        </td>

    </tr>



</table>

</body>
</html>