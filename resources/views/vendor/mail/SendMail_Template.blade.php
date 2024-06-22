<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="font-family: 'Poppins', Arial, sans-serif">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding: 20px;">
                <table class="content" width="600" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse; border: 1px solid #cccccc;">
                    <!-- Header -->
                    <tr>
                        <td class="header" style="background-color: #023047; padding: 30px; text-align: center; color: white; font-size: 24px; border-radius: 8px 8px 0 0;">
                            TOEIC POLITEKNIK NEGERI BALI
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="body" style="padding: 40px; text-align: left; font-size: 16px; line-height: 1.6;">
                        Hello, <b>{{$person->user->name}}!</b> <br>
                        How are you? we hope you are fine.
                        <br><br>
                        Below is your TOEIC account which will be used to log in to the TOEIC system
                        </td>
                    </tr>

                    <tr>
                        <td class="body" style="padding: 10px 40px; font-size: 16px; line-height: 1.6;">
                            <table width="500">
                                <tr>
                                    <td><b>Username</b></td>
                                    <td>:</td>
                                    <td>{{$person->user->name}}</td>
                                </tr>
                                <tr>
                                    <td><b>Email</b></td>
                                    <td>:</td>
                                    <td>{{$person->user->email}}</td>
                                </tr>
                                <tr>
                                    <td><b>Password</b></td>
                                    <td>:</td>
                                    <td>{{$person->token}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="body" style="padding: 40px; text-align: left; font-size: 16px; line-height: 1.6;">
                            Regards, 
                            <br>
                            Politeknik Negeri Bali
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>