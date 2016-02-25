<div style="margin:0;padding:0" dir="ltr" bgcolor="#ffffff">
    <table cellspacing="0" cellpadding="0" width="100%;" border="0" style="border-collapse:collapse">
        <tbody>
        <tr>
            <td style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;background:#ffffff">
                <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:collapse">
                    <tbody>
                    <tr>
                        <td height="20" style="line-height:20px" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
                        <td>
                            <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:collapse">
                                <tbody>
                                <tr>
                                    <td height="28" style="line-height:28px">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823">Reset your password.</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="14" style="line-height:14px">&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
                        <td>
                            <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:collapse">
                                <tbody>
                                <tr>
                                    <td height="2" style="line-height:2px" colspan="3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ url('password/reset/'.$token) }}"
                                           style="color:#1ABC9C;text-decoration:none" target="_blank">
                                            <table cellspacing="0" cellpadding="0" width="100%"
                                                   style="border-collapse:collapse">
                                                <tbody>
                                                <tr>
                                                    <td style="border-collapse:collapse;border-radius:2px;text-align:center;display:block;border:solid 1px #16a085;background:#1ABC9C;padding:7px 16px 11px 16px">
                                                        <a href="{{ url('password/reset/'.$token) }}"
                                                           style="color:#1ABC9C;text-decoration:none;display:block"
                                                           target="_blank">
                                                            <center><font size="3"><span
                                                                            style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;white-space:nowrap;font-weight:bold;vertical-align:middle;color:#ffffff;font-size:14px;line-height:14px">Reset password</span></font>
                                                            </center>
                                                        </a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </a></td>
                                    <td width="100%"></td>
                                </tr>
                                <tr>
                                    <td height="32" style="line-height:32px" colspan="3">&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
                        <td>
                            <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:collapse">
                                <tbody>
                                <tr>
                                    <td height="14" style="line-height:14px">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:14px;line-height:19px;color:#898f9c">
                                            At Equimundo you can follow your favourite horses and contact their owners. <br>
                                            As a member of Equimundo you can share updates pictures and much more.
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="14" style="line-height:14px">&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
                        <td>
                            <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:collapse">
                                <tbody>
                                <tr>
                                    <td height="14" style="line-height:14px">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:14px;line-height:19px;color:#898f9c">
                                            We are still developing very hard to give you the best experience. <br>
                                            If you notice any strange things or you have request or a question, don't hesitate to contact us.
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="14" style="line-height:14px">&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="15" style="display:block;width:15px">&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td height="20" style="line-height:20px" colspan="3">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
        </tr>
        </tbody>
    </table>
</div>


{{ trans('emails.reset_password') }} {{ url('password/reset/'.$token) }}
