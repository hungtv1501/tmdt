@extends('frontend.base-layout')

@section('content')
   <div class="panel-body">
                    <p>Khi mua h&agrave;ng tại TMDT, t&ugrave;y theo sự lựa chọn của Kh&aacute;ch h&agrave;ng, hệ thống sẽ tự động t&iacute;nh ph&iacute; vận chuyển dựa v&agrave;o c&aacute;c c&aacute;ch t&iacute;nh sau:</p>

<p>&nbsp;</p>

<p><span style="color:#0000FF;"><span style="font-size:14px;"><strong>1) Ph&iacute; vận chuyển từ Trung Quốc - Việt Nam:</strong> </span></span>bắt buộc với tất cả c&aacute;c đơn h&agrave;ng</p>

<p style="margin-left: 40px;"><br />
L&agrave; mức ph&iacute; vận chuyển từ kho của Người b&aacute;n (được chia th&agrave;nh c&aacute;c v&ugrave;ng t&iacute;nh cước kh&aacute;c nhau) về đến kho của TMDT (tại H&agrave; Nội). Mức ph&iacute; n&agrave;y được t&iacute;nh dựa tr&ecirc;n trọng lượng của đơn h&agrave;ng v&agrave; khoảng c&aacute;ch của Người b&aacute;n đến kho của TMDT.&nbsp;<br />
Cước ph&iacute; vận chuyển từ Trung Quốc về Việt Nam (kho của TMDT tại H&agrave; Nội) được t&iacute;nh dựa v&agrave;o bảng gi&aacute; sau:</p>

<p style="margin-left: 40px;">&nbsp;</p>

<p style="margin-left: 40px; text-align: center;"><span style="font-size:14px;"><strong>BẢNG GI&Aacute; VẬN CHUYỂN TRUNG QUỐC - VIỆT NAM</strong></span></p>

<p style="margin-left: 40px; text-align: center;"><span style="color:#FF0000;"><strong><em>(ĐƠN GI&Aacute; / 01 KG H&Agrave;NG H&Oacute;A)</em></strong></span></p>

<table align="center" border="1" cellpadding="1" cellspacing="1" style="width: 500px;">
  <tbody>
    <tr>
      <td>
      <table align="center" border="1" cellpadding="0" cellspacing="0" style="width: 573px;" width="572">
        <colgroup>
          <col />
          <col span="3" />
          <col />
        </colgroup>
        <tbody>
          <tr height="45">
            <td height="65" rowspan="2" style="height: 65px; width: 143px; text-align: center;">
            <p><strong>MỨC TRỌNG LƯỢNG</strong></p>

            <p><strong>(KG)</strong></p>
            </td>
            <td colspan="3" style="width: 244px; text-align: center;"><strong>ĐƠN GI&Aacute; (đ/kg)</strong></td>
            <td rowspan="2" style="width: 187px; text-align: center;"><strong>GHI CH&Uacute;</strong></td>
          </tr>
          <tr height="20">
            <td height="20" style="height: 20px; width: 81px; text-align: center;"><strong>V&ugrave;ng 1</strong></td>
            <td style="width: 81px; text-align: center;"><strong>V&ugrave;ng 2</strong></td>
            <td style="width: 81px; text-align: center;"><strong>V&ugrave;ng 3</strong></td>
          </tr>
          <tr height="45">
            <td height="45" style="height:45px;width:143px;">&nbsp;&lt;=1kg</td>
            <td style="width: 81px; text-align: right;">55.000</td>
            <td style="width: 81px; text-align: right;">&nbsp;60.000</td>
            <td style="width: 81px; text-align: right;">&nbsp;70.000</td>
            <td rowspan="6" style="width:187px;">Trọng lượng t&iacute;nh ri&ecirc;ng theo từng đơn h&agrave;ng, l&agrave;m tr&ograve;n theo từng nấc 1kg.<br />
            &nbsp;(vd: 0.8kg l&agrave;m tr&ograve;n th&agrave;nh 1kg)</td>
          </tr>
          <tr height="20">
            <td height="20" style="height:20px;width:143px;">&nbsp; tr&ecirc;n 1-dưới 3kg</td>
            <td style="width: 81px; text-align: right;">50.000</td>
            <td style="width: 81px; text-align: right;">55.000</td>
            <td style="width: 81px; text-align: right;">65.000</td>
          </tr>
          <tr>
            <td height="20" style="height:20px;width:143px;">&nbsp; tr&ecirc;n 3 - dưới 5kg</td>
            <td style="width: 81px; text-align: right;">45.000</td>
            <td style="width: 81px; text-align: right;">50.000</td>
            <td style="width: 81px; text-align: right;">60.000</td>
          </tr>
          <tr>
            <td height="20" style="height:20px;width:143px;">&nbsp;tr&ecirc;n 5 - dưới 10kg</td>
            <td style="width: 81px; text-align: right;">40.000</td>
            <td style="width: 81px; text-align: right;">45.000</td>
            <td style="width: 81px; text-align: right;">55.000</td>
          </tr>
          <tr>
            <td height="20" style="height:20px;width:143px;">&nbsp;tr&ecirc;n 10kg</td>
            <td style="width: 81px; text-align: right;">35.000</td>
            <td style="width: 81px; text-align: right;">40.000</td>
            <td style="width: 81px; text-align: right;">50.000</td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
  </tbody>
</table>

<p style="margin-left: 40px;">&nbsp;</p>

<p style="margin-left: 40px;"><u style="text-align: justify;"><strong>* Ghi ch&uacute;:</strong></u></p>

<p style="margin-left: 40px;"><span style="text-align: justify;">- &nbsp;Ph&acirc;n chia v&ugrave;ng t&iacute;nh cước vận chuyển từ Trung Quốc về Việt Nam:</span></p>

<ul style="margin-left: 40px;">
  <li style="text-align: justify; margin-left: 40px;"><strong>V&Ugrave;NG &nbsp;1: </strong>Quảng T&acirc;y, Quảng Đ&ocirc;ng, Qu&yacute; Ch&acirc;u, Hồ Nam.&nbsp;</li>
  <li style="text-align: justify; margin-left: 40px;"><strong>V&Ugrave;NG 2: </strong>Tr&ugrave;ng Kh&aacute;nh, Hồ Bắc, Ph&uacute;c Kiến, Thượng Hải, V&acirc;n Nam, H&agrave; Nam, Tr&ugrave;ng Kh&aacute;nh, An Huy, Tứ Xuy&ecirc;n.</li>
  <li style="text-align: justify; margin-left: 40px;"><strong>V&Ugrave;NG 3: </strong><span style="text-align: justify;">Giang T&ocirc;,&nbsp;</span>Sơn Đ&ocirc;ng, <span style="text-align: justify;">Chiết Giang,</span>&nbsp;H&agrave; Bắc, Bắc Kinh, Sơn T&acirc;y, <span style="text-align: justify;">Giang T&acirc;y,&nbsp;</span>Li&ecirc;u Ninh, Hắc Long Giang, Nội M&ocirc;ng, C&aacute;t L&acirc;m, Ninh Hạ, T&acirc;n Cương, Thanh Hải, Cam T&uacute;c, T&acirc;y Tạng, Thi&ecirc;n T&acirc;n.</li>
</ul>

<p><br />
<span style="color:#0000FF;"><span style="font-size:14px;"><strong>2) Ph&iacute; giao h&agrave;ng trong nước (Việt Nam):&nbsp;</strong></span></span></p>

<p style="margin-left: 40px; text-align: justify;">&nbsp;</p>

<p style="margin-left: 40px; text-align: justify;">L&agrave; mức ph&iacute; giao h&agrave;ng từ kho của TMDT (tại H&agrave; Nội) đến tay Kh&aacute;ch h&agrave;ng. Kể từ ng&agrave;y 05/6/2014, TMDT &aacute;p dụng hai h&igrave;nh thức giao h&agrave;ng như sau:&nbsp;</p>

<p style="margin-left: 40px; text-align: justify;">&nbsp;</p>

<p style="margin-left: 40px; text-align: justify;">+ Nhận h&agrave;ng tại kho của TMDT tại H&agrave; Nội: <strong>Kh&ocirc;ng mất ph&iacute;</strong></p>

<p style="margin-left: 40px; text-align: justify;">+ Nhận h&agrave;ng tại kho của TMDT tại TP. HCM: &nbsp;ph&iacute; 17.000đ/kg (thanh to&aacute;n khi nhận h&agrave;ng v&agrave; t&iacute;nh theo trọng lượng thực tế của kiện h&agrave;ng sau khi đ&atilde; gộp c&aacute;c đơn h&agrave;ng)</p>

<p style="margin-left: 40px; text-align: justify;">+ Nhận h&agrave;ng tại địa chỉ của Kh&aacute;ch h&agrave;ng:</p>

<p style="margin-left: 40px; text-align: justify;"><span style="color:#FF0000;">Nhằm n&acirc;ng cao chất lượng phục vụ kh&aacute;ch h&agrave;ng v&agrave; để đa dạng hơn trong việc lựa chọn nh&agrave; cung cấp Chuyển Ph&aacute;t Nhanh trong nước,&nbsp;<br />
TMDT sẽ thực hiện thay đổi việc trả cước ph&iacute; Chuyển Ph&aacute;t Nhanh trong nước từ h&igrave;nh thức Người Nhận Trả Cước sang h&igrave;nh thức thu cước trước sau đ&oacute; mới gửi h&agrave;ng<br />
Vậy TMDT xin th&ocirc;ng b&aacute;o đến qu&yacute; kh&aacute;ch h&agrave;ng được biết. Việc thay đổi sẽ được &aacute;p dụng từ ng&agrave;y 11/09/2017.<br />
Mọi chi tiết xin li&ecirc;n hệ bộ phận CSKH. Cảm ơn qu&yacute; kh&aacute;ch</span>.

<p style="margin-left: 40px; text-align: justify;"><span style="font-size:12px;"><span style="color:#FF0000;"><strong><u>* Lưu &yacute;:</u></strong></span></span></p>

<p style="margin-left: 40px; text-align: justify;">Đối với c&aacute;c trường hợp nhận h&agrave;ng hộ (người nhận h&agrave;ng kh&ocirc;ng phải l&agrave; người sở hữu t&agrave;i khoản c&oacute; đơn h&agrave;ng tương ứng tr&ecirc;n TMDT), TMDT chỉ đồng &yacute; giao h&agrave;ng cho người nhận hộ sau khi Qu&yacute; kh&aacute;ch sau khi nhận được ủy quyền như sau:</p>

<p style="margin-left: 40px; text-align: justify;">C&aacute;ch thực hiện:</p>
</div>

@endsection