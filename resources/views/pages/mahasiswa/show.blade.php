<table class="table table-bordered">
  <tr>
    <td></td>
    <td><img src="/image/mahasiswa/{{ $item->photo }}" alt="foto" width="100" height="100"></td>
  </tr>
  <tr>
    <th>Nrp</th>
    <td>{{ $item->nrp }}</td>
  </tr>
  <tr>
    <th>Nama</th>
    <td>{{ $item->nama }}</td>
  </tr>
  <tr>
    <th>Alamat</th>
    <td>{{ $item->alamat }}</td>
  </tr>
  <tr>
    <th>Program Studi</th>
    <td>{{ $item->prodis->prodi }}</td>
  </tr>
  <tr>
    <th>Kelas</th>
    @if ($item->id_kelas === NULL)
      <td></td>
    @else
      <td>{{ $item->kelas->nama }}</td>
    @endif
  </tr>
  <tr>
    <th>Telpon</th>
    <td>{{ $item->telp }}</td>
  </tr>
</table>
