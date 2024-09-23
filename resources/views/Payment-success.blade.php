<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }
        .container {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container" style=" width: 450px;">
        <table style="width: 100%; margin-bottom: 0px;">
            <tr>
                <td style="text-align: center;">
                    <img src="3d-illustration-of-payment-success-png.webp" alt="Success" style="width: 150px;height: 150px;">
                </td>
            </tr>
        </table>
        <h2 style="margin: 0px;margin-bottom: 20px;"> Payment Successful!</h2>
        <p>Thank you! Your payment of Rs. 3000 has been received.</p>
        <!-- <p>Order ID: IC-1234, IC-5678 | Transaction ID: 12345</p> -->
        <table style="
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        /* background-color: #ebebeb; */
        ">
            <tbody><tr>
                <td style="padding: 10px;border: 1px solid #ddd;background: none !important;">MemberShip Type</td>
                <td style="padding: 10px;border: 1px solid #ddd;text-align: right;">Associate Member</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd;">Amount Paid</td>
                <td style="padding: 10px;border: 1px solid #ddd;text-align: right;font-size: 15px;font-weight: bold;">₹ 3000</td>
            </tr>
        </tbody></table>
        <!-- <p>Please wait for some time for the amount to show up in your Canvera account.</p>
        <p>Please contact us at 1800- or email to care@canvera.com for any query.</p> -->
        <form name="ecom" method="post" action="https://test.sbiepay.sbi/secure/AggregatorHostedListener">
            <input type="hidden" name="EncryptTrans" value="">
            <input type="hidden" name="MultiAccountInstructionDtls" value="">
            <input type="hidden" name="merchIdVal" value ="1000356"/>
            <a href="#" class="button">
                <button type="submit" style="
                stroke-linecap: butt;
                background: none;
                border: none;
                color: white;
            ">Pay the Amount</button>
                </a> 
            </form>
    </div>
</body>
</html>