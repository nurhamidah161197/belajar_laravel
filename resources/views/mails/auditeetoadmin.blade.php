Kepada Yth,<br>
<b>Tim Audit PIHC</b>
<br><br>
Anda mendapatkan tanggapan tindak lanjut dari auditee atas rekomendasi LHA, yaitu:
<br><br>
<table>
  <tr>
    <td style="width:150px">
      Nomor Laporan
    </td>
    <td style="width:1px">
      :
    </td>
    <td>
      {{ $master->no_lha }}
    </td>
  </tr>
  <tr>
    <td>
      Objek Audit
    </td>
    <td>
      :
    </td>
    <td>
      {{ $master->obj_audit }}
    </td>
  </tr>
  <tr>
    <td colspan="3">
      @foreach($rekomendasi as $rekomendasi_)
      <ul>
        <li>
          <b>Rekomendasi :</b><br>
          {!! stripslashes(nl2br($rekomendasi_->rekomendasi)) !!}<br><br>
          <ul>
            <li>
                <b>{!! $rekomendasi_->ORG_NAME !!} - Tindak Lanjut : </b><br>
                {!! stripslashes(nl2br($rekomendasi_->tindak_lanjut_temp)) !!}
            </li>
          </ul>
        </li>
      </ul>
      @endforeach
    </td>
  </tr>
</table>
<br>
SIlahkan klik http://montilan.pupuk-indonesia.com untuk mengakses SI-Montilan dan mengevaluasi TL tersebut.
