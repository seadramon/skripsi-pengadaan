<!DOCTYPE html>
<html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <style media="screen">
        body {
          width: 100%;
          display: block;
          font-family: arial, sans-serif;
          font-weight: 300;
          font-size: 16px;
          line-height: 1.35;
          text-align: center;
          padding: 0;
          margin: 0;
          background: #eee;
        }


    </style>
    </head>

    <body>
    <table class="wrapper" style="width: 85%; display: inline-block; text-align: left; font-size: 0; background-color: white; border-collapse: collapse; border-radius: 6px; border-top: .5rem solid #00AFFF;">
      <tr class="header" style="width:100%">
        <td>
          <img style="width:100%" src="http://scmsummit.co.id/assets/email/img/header-ok.jpg" />
        </td>
      </tr>
      <tr class="content" style="display: block; width: 100%; font-size: 1rem;">
        <td class="mail-content" style="display: block; width: auto; padding: 1rem 2rem; color: #555;">
          <h2 style="font-weight: 500; font-size: 2rem; line-height: 1;">SELAMAT!</h2>
          <p>Anda telah berhasil teregistrasi sebagai peserta pada acara SCM Summit 2015. Silahkan
          perhatikan hal penting di bawah ini</p>
        </td>
      </tr>
      <tr>
        <td style="width:100%; margin:1rem auto;" >
            <img style="display:inline-block; width: 50%; text-align: center;" src="<?=base_url()?>showqr?email=<?=$email?>">
        </td>
      </tr>
      <tr>
        <td>
          <h3 style="font-weight: 700; font-size: 1rem; line-height: 1;">Informasi login anda</h3>
          <ul>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Email: <span style="font-weight: 700;"><?=$email?></span></li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Password: <span style="font-weight: 700;"><?=$password?></span></li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Phone Number: <span style="font-weight: 700;"><?=$phone?></span></li>
          </ul>
          <br>
          <h3 style="font-weight: 700; font-size: 1rem; line-height: 1;">Registrasi</h3>
          <ul>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Peserta akan dikenakan biaya sebagai peserta yang akan hadir.
                Tidak ada pengembalian pembayaran kepada peserta yang sudah terdaftar.</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Email konfirmasi akan digunakan sebagai bukti pembayaran pendaftaran.</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Silahkan login pada tautan ini untuk melihat profil anda http://scmsummit.co.id/login masukan email dan password di atas. </li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Mohon lakukan pembayaran dan upload bukti transfer anda pada halaman profil di tautan ini http://scmsummit.co.id/login</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Biaya pendaftaran untuk peserta adalah sebesar Rp. 8.000.000 / peserta dan dapat dibayarkan sebelum tanggal 10 April 2015.</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Biaya pendaftaran untuk Exhibitor adalah sebesar Rp. 12.000.000 Pembayaran dapat dibayarkan sebelum tanggal 5 April 2015</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Pembayaran dapat ditransfer melalui Bank Mandiri Cabang Ratu Plaza dengan Nomor Rekening 122-00-0592232-6 Atas Nama PT. GLOBAL CITRA KREASI</li>
          </ul>
          <h3 style="font-weight: 700; font-size: 1rem; line-height: 1;">Acara</h3>
          <ul>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Check-in dibuka setiap jam 7 Pagi harap membawa email konfirmasi ini (bisa di print atau
                ditunjukan langsung dari handphone). Kami akan memindai barcode sebagai pengenal registrasi anda.</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Seminar kit (goodie bag and name tag) akan dibagikan kepada semua peserta disaat menghadiri pendaftaran.</li>
          </ul>
          <p>Terimakasih atas partisipasi anda pada acara ini.
          <br><br><br>
          Salam,<br>
          <strong>Panitia SCM Summit 2015</strong></p>
        </td>
      </tr>
      <tr>
        <td>
          <br>
          <hr>
          <br>
        </td>
      </tr>
      <tr>
        <td>
          <h2 style="font-weight: 500; font-size: 2rem; line-height: 1;">CONGRATULATIONS!</h2>
          <p>You are successfully registered as participant in SCM Summit 2015.
          Please take a look at important matters below :</p>
        </td>
      </tr>
      <tr>
        <td style="width:100%; margin:1rem auto;" >
            <img style="display:inline-block; width: 70%; text-align: center;" src="<?=base_url()?>showqr?email=<?=$email?>">
        </td>
      </tr>
      <tr>
        <td>
          <h3 style="font-weight: 700; font-size: 1rem; line-height: 1;">Your Login Details</h3>
          <ul>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Email: <span style="font-weight: 700;"><?=$email?></span></li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Password: <span style="font-weight: 700;"><?=$password?></span></li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Phone Number: <span style="font-weight: 700;"><?=$phone?></span></li>
          </ul>
          <br>
          <h3 style="font-weight: 700; font-size: 1rem; line-height: 1;">Registration</h3>
          <ul>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Registered Participant will be charged as attended participant. No refund of payment to the
                participant's Company who already registered.</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">This confirmation letter is used as your registration payment receipt.</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Please login using your email and password above to this URL http://scmsummit.co.id/ to view your profile page.</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Please make a payment and upload the proof of payment onto your profile page on this URL http://scmsummit.co.id/login<</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Registration Fee for Summit Participant is Rp. 8.000.000 payment should be made before 10 April 2015</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Registration Fee for Exhibitor is Rp. 12.000.000 payment should be made before 5 April 2015</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Payment can be transfered through Bank Mandiri branch Ratu Plaza with account number 122-00-0592232-6 named as PT. GLOBAL CITRA KREASI</li>
          </ul>
          <h3 style="font-weight: 700; font-size: 1rem; line-height: 1;">Events</h3>
          <ul>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Daily Registration open 07.00 please kindly bring this confirmation letter (printed or in your
                phone). We will scan the barcode as your registration ID.</li>
            <li style="margin: .5rem 0; line-height: 1.5rem;">Seminar kit (goodie bag and name tag) will be distributed to all participants on Registration
                upon arrival.</li>
          </ul>
          <p>Thank you for participation in this events.
          <br><br><br>
          Best Regards,<br>
          <strong>SCM Summit 2015 Committee</strong></p>
        </td>
      </tr>
      <tr class="footer" style="display: block; font-size: 1rem; padding: 1rem 2rem; color: white; border-radius: 0 0 6px 6px; background-color: #0A2832;">
        <td class="contact" style="display: block; width: 100%; text-align: center;">
          <h3 style="font-size: 1rem; line-height: 1rem; color: #00AFFF;">HUBUNGI</h3>
            <strong>Ms. Puspita Damaranti (Ranti)</strong><br>
            <strong>T.</strong>&nbsp; +62812-1068-8723 <br>
            <strong>E.</strong>&nbsp; <span style="color:white; text-decoration:none;">scmsummit2015@gmail.com</span>
        </td>
        <td class="sponsor" style="display: block; width: 100%; text-align: center; margin-top: 1rem">
          <h3 style="font-size: 1rem; line-height: 1rem; color: #00AFFF;">PENYELENGGARA</h3>
          <img style="max-height: 60px; margin-left: 1rem;" src="http://scmsummit.co.id/assets/email/img/logo_skkmigas.png" />
          <img style="max-height: 60px; margin-left: 1rem;" src="http://scmsummit.co.id/assets/email/img/logo_petronas.png" />
          <img style="max-height: 60px; margin-left: 1rem;" src="http://scmsummit.co.id/assets/email/img/logo_bp.png" />
        </td>
        <td class="copyright" style="display: block; font-size: .75rem; text-align: center; color: #B4BEC8; margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #B4BEC8;">
          You are receiving this email because you opted in when you register as participant through our website  <br>
          © 2015 SKK Migas. Hak penerbitan konten dan kepemilikan web sepenuhnya dimiliki dan disetujui oleh SKK Migas.
          Event ini di organisir oleh Global Event Management
        </td>
      </tr>
    </table>

    </body>
</html>
